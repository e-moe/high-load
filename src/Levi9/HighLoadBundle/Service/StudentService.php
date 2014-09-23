<?php

namespace Levi9\HighLoadBundle\Service;

use Doctrine\ORM\EntityManager;
use Levi9\HighLoadBundle\Entity\Student;

class StudentService
{
    const BATCH_SIZE = 50;

    /** @var EntityManager */
    private $em;

    private $cache = [];

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function generatePath()
    {
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);
        // see http://doctrine-orm.readthedocs.org/en/latest/reference/batch-processing.html#iterating-results
        $i = 0;
        $q = $this->em->createQuery('select s from Levi9\HighLoadBundle\Entity\Student s');
        $iterableResult = $q->iterate();
        foreach ($iterableResult as $row) {
            /** @var Student $student */
            $student = $row[0];
            $path = $this->getUniquePath($student->getName());
            $student->setPath($path);
            if (($i % self::BATCH_SIZE) === 0) {
                $this->em->flush(); // Executes all updates.
                $this->em->clear(); // Detaches all objects from Doctrine!
                gc_collect_cycles();
            }
            ++$i;
        }
        $this->em->flush();
    }

    public function encodeString($subject)
    {
        $sanitized = preg_replace('/\W/u', '_', $subject);
        $lower = mb_strtolower($sanitized);
        $trimmed = trim($lower, '_');
        return preg_replace('/_{2,}/u', '_', $trimmed);
    }

    public function getUniquePath($path)
    {
        $path = $this->encodeString($path);
        if (isset($this->cache[$path])) {
            $i = 1;
            do {
                $pathCheck = $path . '_' . $i++;
            } while (isset($this->cache[$pathCheck]));
            $path = $pathCheck;
        }

        $this->cache[$path] = true;
        return $path;
    }
}
