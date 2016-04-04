<?php

namespace App\Components;

use App\Model\Entity\Attendance;
use App\Model\Entity\Day;
use App\Model\Entity\Grade;
use App\Model\Entity\TypeAttendance;
use App\Model\Entity\TypeClass;
use App\Model\EntityService\StudentAttendanceQuery;
use App\Model\Service\AttendanceTypeService;
use Doctrine\ORM\EntityManager;
use Grido\Components\Filters\Filter;
use Grido\DataSources\Doctrine;
use Grido\Grid;

interface IAttendanceChangeFactory
{

    /**
     * @param Grade     $grade
     * @param TypeClass $typeClass
     * @param Day       $day
     * @return AttendanceChange
     */
    public function create(Grade $grade, TypeClass $typeClass, Day $day);

}

/**
 * Class AttendanceChange
 * @package App\Components
 */
class AttendanceChange extends BaseComponent
{

    /** @var  Grade */
    private $grade;

    /** @var  TypeClass */
    private $typeClass;

    /** @var  Day */
    private $day;

    /** @var EntityManager */
    private $entityManager;

    /** @var  AttendanceTypeService */
    private $AttendanceTypeService;


    /**
     * @param EntityManager $entityManager
     */
    public function __construct(Grade $grade, TypeClass $typeClass, Day $day, EntityManager $entityManager, AttendanceTypeService $AttendanceTypeService)
    {
        $this->grade = $grade;
        $this->typeClass = $typeClass;
        $this->day = $day;
        $this->entityManager = $entityManager;
        $this->AttendanceTypeService = $AttendanceTypeService;
    }

    public function render()
    {
        $this->template->render();
    }

    public function createComponentEditAttendance($name)
    {
        $entityManager = $this->entityManager;
        $query = new StudentAttendanceQuery();

        $query->setDay($this->presenter->getParameter('day'));
        $query->setClass($this->presenter->getParameter('grade'), $this->presenter->getParameter('typeClass'));

        $grid = new Grid($this, $name);
        $grid->setModel(new Doctrine($query->doCreateQuery($entityManager->getRepository(Attendance::class))));
        $grid->setDefaultPerPage(100);
        $grid->setFilterRenderType(Filter::RENDER_INNER);
        $grid->setRememberState();

        $grid->setDefaultSort(array('id' => 'ASC'));
        $grid->addColumnText('student.name', 'Jméno');
        $grid->addColumnText('student.surname', 'Příjmení');
        $grid->addColumnText('typeAttendance.name', 'Účast');

        $attendanceTypes = $this->AttendanceTypeService->getAllAttendanceType();
        foreach ($attendanceTypes as $key => $attendanceType) {
            $grid->addActionEvent($key, $attendanceType, function ($id, $column) use ($entityManager, $key) {
                $attendanceEntity = $entityManager->getRepository(Attendance::class)->findOneBy(['id' => $id]);
                $attendanceTypeEntity = $entityManager->getRepository(TypeAttendance::class)->findOneBy(['id' => $key]);
                $attendanceEntity->typeAttendance = $attendanceTypeEntity;
                $entityManager->flush();
                return TRUE;
            });
        }


        //$grid->addActionHref();

        return $grid;
    }

}