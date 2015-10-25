<?php

namespace App\Components;


use App\Model\Entity\Student;
use App\Model\EntityService\StudentQuery;
use Doctrine\ORM\EntityManager;

class StudentList extends BaseComponent
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function render()
    {
        $query = new StudentQuery();
        $query->setClass('4A');
        $this->template->students = $this->entityManager->getRepository(Student::class)->fetch($query);
        $this->template->render();
    }
}

interface IStudentListFactory
{

    /**
     * @return StudentList
     */
    public function create();

}