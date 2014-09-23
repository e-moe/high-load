<?php

namespace Levi9\HighLoadBundle\Command;

use Levi9\HighLoadBundle\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StudentCommand extends ContainerAwareCommand
{
    const BATCH_SIZE = 50;

    protected function configure()
    {
        $this
            ->setName('student:generate:path')
            ->setDescription('Generate path for students')
        ;
    }

    protected function generatePath()
    {
        /** @var StudentService $studentService */
        $studentService = $this->getContainer()->get('levi9_high_load.student');

        $em =$this->getContainer()->get('doctrine.orm.entity_manager');
        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        // see http://doctrine-orm.readthedocs.org/en/latest/reference/batch-processing.html#iterating-results
        $i = 0;
        $q = $em->createQuery('select s from Levi9\HighLoadBundle\Entity\Student s');
        $iterableResult = $q->iterate();
        foreach ($iterableResult as $row) {
            /** @var Student $student */
            $student = $row[0];
            $path = $studentService->getUniquePath($student->getName());
            $student->setPath($path);
            if (($i % self::BATCH_SIZE) === 0) {
                $em->flush(); // Executes all updates.
                $em->clear(); // Detaches all objects from Doctrine!
                gc_collect_cycles();
            }
            ++$i;
        }
        $em->flush();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startTime = microtime(true);

        $this->generatePath();

        $timeElapsed = microtime(true) - $startTime;
        $output->writeln(
            sprintf('Time elapsed: %.3f s', $timeElapsed)
        );
        $output->writeln(
            sprintf('Memory usage: %.3f Mb', memory_get_peak_usage() / 2**20)
        );
    }
}
