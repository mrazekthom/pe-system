<?php

namespace App\Model\Service;

use Kdyby\Doctrine\EntityManager;

class SchoolTimetableService
{

    /** @var  EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


}