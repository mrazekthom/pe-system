<?php

namespace App\Components;


use App\Model\Entity\TypeAttendance;
use App\Model\EntityService\AttendanceTypeQuery;
use Doctrine\ORM\EntityManager;
use Grido\Components\Filters\Filter;
use Grido\DataSources\Doctrine;
use Grido\Grid;

interface IAttendanceTypeChangeFactory
{


    /**
     * @return AttendanceTypeChange
     */
    public function create();

}

/**
 * Class AttendanceTypeChange
 * @package App\Components
 */
class AttendanceTypeChange extends BaseComponent
{

    /** @var EntityManager */
    private $entityManager;


    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function render()
    {
        $this->template->render();
    }

    public function createComponentEditAttendanceType($name)
    {
        $entityManager = $this->entityManager;
        $query = new AttendanceTypeQuery();

        $grid = new Grid($this, $name);
        $grid->setModel(new Doctrine($query->doCreateQuery($entityManager->getRepository(TypeAttendance::class))));
        $grid->setDefaultPerPage(100);
        $grid->setFilterRenderType(Filter::RENDER_INNER);

        $grid->addColumnText('name', 'Typ účasti')
            ->setEditableCallback(function ($id, $newValue, $oldValue, $column) use ($entityManager) {
                $attendanceTypeEntity = $entityManager->getRepository(TypeAttendance::class)->findOneBy(['id' => $id]);
                $attendanceTypeEntity->name = $newValue;
                $entityManager->flush();
                return TRUE;
            });

        $grid->addColumnNumber('percent_attendance', 'procentuální účast')
            ->setEditableCallback(function ($id, $newValue, $oldValue, $column) use ($entityManager) {
                $attendanceTypeEntity = $entityManager->getRepository(TypeAttendance::class)->findOneBy(['id' => $id]);
                $attendanceTypeEntity->percentAttendance = $newValue;
                $entityManager->flush();
                return TRUE;
            });

        //$grid->addActionHref();

        return $grid;
    }

}