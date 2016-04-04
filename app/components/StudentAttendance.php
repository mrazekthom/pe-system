<?php

namespace App\Components;

use App\Model\Entity\Attendance as EAttendance;
use App\Model\Entity\Grade;
use App\Model\Entity\Student;
use App\Model\Entity\TypeAttendance;
use App\Model\Entity\TypeClass;
use App\Model\EntityService\StudentAttendanceQuery;
use App\Model\Service\AttendanceTypeService;
use Doctrine\ORM\EntityManager;
use Grido\Components\Filters\Filter;
use Grido\DataSources\Doctrine;
use Grido\Grid;

interface IStudentAttendanceFactory
{

    /**
     * @param int $id
     * @return StudentAttendance
     */
    public function create($id);

}

/**
 * Class StudentAttendance
 * @package App\Components
 */
class StudentAttendance extends BaseComponent
{

    /** @var EntityManager */
    private $entityManager;

    /** @var  $studentID */
    private $studentID;

    /** @var  AttendanceTypeService */
    private $AttendanceTypeService;

    /**
     * @param Grade         $grade
     * @param TypeClass     $typeClass
     * @param EntityManager $entityManager
     */
    public function __construct($id, EntityManager $entityManager, AttendanceTypeService $AttendanceTypeService)
    {
        $this->studentID = $id;
        $this->entityManager = $entityManager;
        $this->AttendanceTypeService = $AttendanceTypeService;
    }

    public function render()
    {
        $entityManager = $this->entityManager;
        $studentEntity = $entityManager->getRepository(Student::class)->findOneBy(['id' => $this->studentID]);
        $this->template->studentName = $studentEntity->getSurName() . ' ' . $studentEntity->getName();
        $this->template->render();
    }

    public function createComponentStudentAttendance($name)
    {
        $entityManager = $this->entityManager;
        $query = new StudentAttendanceQuery();
        $query->setStudentID($this->studentID);

        $grid = new Grid($this, $name);
        $grid->setModel(new Doctrine($query->doCreateQuery($this->entityManager->getRepository(EAttendance::class))));
        $grid->setDefaultPerPage(100);
        $grid->setFilterRenderType(Filter::RENDER_INNER);

        $grid->addColumnDate('day.day', 'Datum')
            ->setCustomRender(function ($attendance) {
                return $attendance->day->day->format('d.m');
            });


        $grid->addColumnText('typeAttendance.name', 'Účast');

        $attendanceTypes = $this->AttendanceTypeService->getAllAttendanceType();
        foreach ($attendanceTypes as $key => $attendanceType) {
            $grid->addActionEvent($key, $attendanceType, function ($id, $column) use ($entityManager, $key) {
                $attendanceEntity = $entityManager->getRepository(EAttendance::class)->findOneBy(['id' => $id]);
                $attendanceTypeEntity = $entityManager->getRepository(TypeAttendance::class)->findOneBy(['id' => $key]);
                $attendanceEntity->typeAttendance = $attendanceTypeEntity;
                $entityManager->flush();
                return TRUE;
            });
        }


        return $grid;
    }

}