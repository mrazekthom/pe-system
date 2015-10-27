<?php

namespace App\Components;


use App\Model\Entity\Grade;
use App\Model\Entity\SchoolClass;
use App\Model\EntityService\ClassQuery;
use Doctrine\ORM\EntityManager;

/**
 * Class ClassList
 * @package App\Components
 */
class ClassList extends BaseComponent
{

    /** @var Grade */
    private $grade;


    /** @var EntityManager */
    private $entityManager;


    /**
     * @param Grade         $grade
     * @param EntityManager $entityManager
     */
    public function __construct(Grade $grade, EntityManager $entityManager)
    {
        $this->grade = $grade;
        $this->entityManager = $entityManager;
    }

    public function render()
    {
        $query = new ClassQuery();
        $query->setGrade($this->grade);
        $this->template->classes = $this->entityManager->getRepository(SchoolClass::class)->fetch($query);
        $this->template->render();
    }
}

interface IClassListFactory
{


    /**
     * @param Grade $grade
     * @return ClassList
     */
    public function create(Grade $grade);

}