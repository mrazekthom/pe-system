<?php

namespace App\Model\Service;

use App\Model\Entity\TypeAttendance;
use App\Model\EntityService\AttendanceTypeQuery;
use Kdyby\Doctrine\EntityManager;

class AttendanceTypeService
{

    /** @var  EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addNewAttendanceType($attendanceType, $percentAttendance)
    {
        $newEntityAttendance = new TypeAttendance();
        $newEntityAttendance->setName($attendanceType);
        $newEntityAttendance->setPercentAttendance($percentAttendance);
        $this->entityManager->persist($newEntityAttendance);
        $this->entityManager->flush();
    }

    public function getAllAttendanceType()
    {
        $query = new AttendanceTypeQuery();

        $attendanceTypeEntities = $this->entityManager->getRepository(TypeAttendance::class)->fetch($query);
        $attendanceTypes = [];
        foreach ($attendanceTypeEntities->getIterator() as $typeAttendance) {
            $attendanceTypes[$typeAttendance->id] = $typeAttendance->name;
        }
        return $attendanceTypes;
    }

}