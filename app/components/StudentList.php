<?php

namespace App\Components;


use App\Model\Entity\Grade;
use App\Model\Entity\Student;
use App\Model\Entity\TypeClass;
use App\Model\EntityService\StudentQuery;
use Doctrine\ORM\EntityManager;
use Grido\DataSources\Doctrine;
use Grido\Grid;

interface IStudentListFactory
{


    /**
     * @param Grade     $grade
     * @param TypeClass $typeClass
     * @return StudentList
     */
    public function create(Grade $grade, TypeClass $typeClass);

}

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

    public function createComponentEditStudent($name)
    {
        $entityManager = $this->entityManager;
        $query = new StudentQuery();
        $query->setClass($this->grade, $this->typeClass);

        $grid = new Grid($this, $name);

        $grid->setModel(new Doctrine($query->doCreateQuery($this->entityManager->getRepository(Student::class))));
        $grid->addColumnNumber('id', '#');
        $grid->addColumnText('class', 'Třída')
            ->setCustomRender(function ($student) {
                return $student->class->grade->grade . $student->class->typeClass->class;
            });
        $grid->addColumnText('surName', 'Přímení')
            ->setEditableCallback(function ($id, $newValue, $oldValue, $column) use ($entityManager) {
                $studentEntity = $entityManager->getRepository(Student::class)->findOneBy(['id' => $id]);
                $studentEntity->surname = $newValue;
                $entityManager->flush();
                return TRUE;
            });
        $grid->addColumnText('name', 'Jméno')
            ->setEditableCallback(function ($id, $newValue, $oldValue, $column) use ($entityManager) {
                $studentEntity = $entityManager->getRepository(Student::class)->findOneBy(['id' => $id]);
                $studentEntity->name = $newValue;
                $entityManager->flush();
                return TRUE;
            });

        $grid->setDefaultPerPage(100);

        $grid->setExport();
    }

}