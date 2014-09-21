<?php

namespace Levi9\HighLoadBundle\Command;

use Levi9\HighLoadBundle\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StudentCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('student:generate:path')
            ->setDescription('Generate path for students')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startTime = microtime(true);
        /** @var StudentService $studentService */
        $studentService = $this->getContainer()->get('levi9_high_load.student');
        $studentService->generatePath();
        $timeElapsed = microtime(true) - $startTime;
        $output->writeln(
            sprintf('Time elapsed: %.3f s', $timeElapsed)
        );
        $output->writeln(
            sprintf('Memory usage: %.3f Mb', memory_get_peak_usage() / 2**20)
        );
    }
}
