<?php

namespace App\Model\Service;

use App\Model\Entity\Attendance;
use App\Model\Entity\Day;
use App\Model\Entity\Grade;
use App\Model\Entity\Student;
use App\Model\Entity\TypeAttendance;
use App\Model\Entity\TypeClass;
use App\Model\EntityService\StudentQuery;
use Kdyby\Doctrine\EntityManager;

class WriteAttendanceService
{


    /** @var  EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function writeAttendanceToDB(Grade $grade, TypeClass $typeClass, $day, $typeAttendance)
    {
        $attendanceTypeEntity = $this->entityManager->getRepository(TypeAttendance::class)->findOneBy(['id' => $typeAttendance]);
        $dayEntity = $this->entityManager->getRepository(Day::class)->findOneBy(['day' => $day]);
        if (!$dayEntity) {
            $newDayEntity = new Day();
            $newDayEntity->setDay($day);
            $this->entityManager->persist($newDayEntity);
            $this->entityManager->flush();
            $dayEntity = $this->entityManager->getRepository(Day::class)->findOneBy(['day' => $day]);
        }
        $query = new StudentQuery();
        $query->setClass($grade, $typeClass);
        $studentEntities = $this->entityManager->getRepository(Student::class)->fetch($query);
        foreach ($studentEntities as $studentEntity) {
            $newEntityAttendance = new Attendance();
            $newEntityAttendance->setStudent($studentEntity);
            $newEntityAttendance->setDay($dayEntity);
            $newEntityAttendance->setTypeAttendance($attendanceTypeEntity);
            $this->entityManager->persist($newEntityAttendance);
        }
        $this->entityManager->flush();
        return $dayEntity;
    }

}