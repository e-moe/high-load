<?php

namespace Levi9\HighLoadBundle\Entity;

use Doctrine\ORM\EntityRepository;

class StudentRepository extends EntityRepository
{
    public function getStudentsIterator()
    {
        return $this->createQueryBuilder('s')->select('s')->getQuery()->iterate();
    }
}
