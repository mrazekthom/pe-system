<?php

namespace App\Model\Service;

use App\Model\Entity\Student;
use App\Model\EntityService\StudentQuery;
use Nette\Object;

class StudentService extends Object
{


    private $EM;

    public function __construct(\Kdyby\Doctrine\EntityManager $entityManager)
    {
        $this->EM = $entityManager;
    }

    public function getStudentFromClass($class)
    {
        $query = new StudentQuery();
        $query->setClass($class);
        return $this->getResult($query);
    }

    public function getStudentFromActualDay()
    {
        $query = new StudentQuery();
        $query->getActualDay();
        return $this->getResult($query);
    }

    public function getStudentFromDay($day)
    {
        $query = new StudentQuery();
        $query->setEducationDay($day);
        return $this->getResult($query);
    }

    public function getStudentFromGrade($grade)
    {
        $query = new StudentQuery();
        $query->setGrade($grade);
        return $this->getResult($query);
    }

    private function getResult($query)
    {
        return $this->EM->getRepository(Student::class)->fetch($query);
    }

}