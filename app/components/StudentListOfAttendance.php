<?php

namespace App\Components;

use App\Model\Entity\Attendance as EntityAttendance;
use App\Model\Entity\Grade;
use App\Model\Entity\Student;
use App\Model\Entity\TypeClass;
use App\Model\EntityService\StudentQuery;
use Doctrine\ORM\EntityManager;
use Grido\Components\Filters\Filter;
use Grido\DataSources\Doctrine;
use Grido\Grid;

interface IStudentListOfAttendanceFactory
{

    /**
     * @param Grade     $grade
     * @param TypeClass $typeClass
     * @return StudentListOfAttendance
     */
    public function create(Grade $grade, TypeClass $typeClass);

}

/**
 * Class StudentListOfAttendance
 * @package App\Components
 */
class StudentListOfAttendance extends BaseComponent
{

    /** @var  Grade */
    private $grade;

    /** @var  TypeClass */
    private $typeClass;

    /** @var EntityManager */
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

    public function createComponentStudentListOfAttendance($name)
    {
        $entityManager = $this->entityManager;
        $query = new StudentQuery();
        $query->setClass($this->grade, $this->typeClass);

        $grid = new Grid($this, $name);
        $grid->setModel(new Doctrine($query->doCreateQuery($this->entityManager->getRepository(Student::class))));
        $grid->setDefaultPerPage(100);
        $grid->setFilterRenderType(Filter::RENDER_INNER);

        $grid->addColumnText('surName', 'Příjmení');
        $grid->addColumnText('name', 'Jméno');


        $dql = $query->doCreateQuery($this->entityManager->getRepository(Student::class));
        foreach ($dql as $entity) {
            $studentId = $entity[0]->id;
            break;
        }
        $attendanceEntityForDay = $entityManager->getRepository(EntityAttendance::class)->findBy(['student.id' => $studentId]);
        foreach ($attendanceEntityForDay as $entity) {
            $grid->addColumnNumber(rand(0, 1000), $entity->day->getDay()->format('d.m'))
                ->setCustomRender(function ($student) use ($entityManager, $entity) {
                    $attendanceEntity = $entityManager->getRepository(EntityAttendance::class)->findOneBy(['student.id' => $student->id, 'day.id' => $entity->day->getId()]);
                    return $attendanceEntity->TypeAttendance->getPercentAttendance();
                });
        }

        $grid->addActionHref('edit', 'Detail', 'Attendance:detail', ['id' => 'id']);

        return $grid;
    }

}