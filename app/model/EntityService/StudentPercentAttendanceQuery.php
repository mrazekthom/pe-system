<?php

namespace App\Model\EntityService;

use App\Model\Entity\Attendance;
use App\Model\Entity\Student;
use App\Model\Entity\TypeAttendance;
use Doctrine\ORM\Query\Expr\Join;
use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;

class StudentPercentAttendanceQuery extends QueryObject
{

    CONST ACTUAL = 1;

    private $studentID;

    public function setStudent(Student $student)
    {
        $this->studentID = $student->getId();
    }

    /**
     * @param \Kdyby\Persistence\Queryable $repository
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    public function doCreateQuery(Queryable $repository)
    {
        $qb = $repository->createQueryBuilder()
            ->select('a')->from(Attendance::class, 'a')
            ->innerJoin(Student::class, 's', Join::WITH, 'a.student = s')
            ->innerJoin(TypeAttendance::class, 't', Join::WITH, 'a.typeAttendance = t')
            ->andWhere('s.id = :student')
            ->setParameter('student', $this->studentID);

        return $qb;
    }

}