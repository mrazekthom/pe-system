<?php

namespace App\Components;


use App\Model\Entity\Grade;
use App\Model\Entity\Student;
use App\Model\Entity\TypeClass;
use App\Model\EntityService\StudentQuery;
use Doctrine\ORM\EntityManager;

/**
 * Class StudentList
 * @package App\Components
 */
class StudentList extends BaseComponent
{

    /** @var  Grade */
    private $grade;

    /** @var  TypeClass */
    private $typeClass;

    /** @var EntityManager  */
    private $entityManager;


    /**
     * @param Grade         $grade
     * @param TypeClass     $typeClass
     * @param EntityManager $entityManager
     */
    public function __construct(Grade $grade, TypeClass $typeClass, EntityManager $entityManager)
    {
        $this->grade = $grade;
        $this->typeClass = $typeClass;
        $this->entityManager = $entityManager;
    }

    public function render()
    {
        $query = new StudentQuery();
        $query->setClass($this->grade, $this->typeClass);
        $this->template->students = $this->entityManager->getRepository(Student::class)->fetch($query);
        $this->template->render();
    }
}

interface IStudentListFactory
{


    /**
     * @param Grade $grade
     * @param TypeClass $typeClass
     * @return StudentList
     */
    public function create(Grade $grade,TypeClass $typeClass);

}