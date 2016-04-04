<?php

namespace App\Model\EntityService;

use App\Model\Entity\Attendance;
use App\Model\Entity\Day;
use App\Model\Entity\Grade;
use App\Model\Entity\SchoolClass;
use App\Model\Entity\SchoolYear;
use App\Model\Entity\Student;
use App\Model\Entity\TypeAttendance;
use App\Model\Entity\TypeClass;
use Doctrine\ORM\Query\Expr\Join;
use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;

class StudentAttendanceQuery extends QueryObject
{

    CONST ACTUAL = 1;

    private $dayID;

    private $gradeID;

    private $typeClassID;

    private $studentID;

    public function setDay(Day $day)
    {
        $this->dayID = $day->getId();
    }

    public function setClass(Grade $grade, TypeClass $typeClass)
    {
        $this->gradeID = $grade->getId();
        $this->typeClassID = $typeClass->getId();
    }

    public function setStudentID($studentID)
    {
        $this->studentID = $studentID;
    }

    /**
     * @param \Kdyby\Persistence\Queryable $repository
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    public function doCreateQuery(Queryable $repository)
    {
        $qb = $repository->createQueryBuilder()
            ->select('a')->from(Attendance::class, 'a')
            ->innerJoin(Student::class, 's', Join::WITH, 'a.student = s');

        if ($this->studentID) {
            $qb->andWhere('s.id = :student')
                ->setParameter('student', $this->studentID);
        } else {
            $qb->innerJoin(Day::class, 'd', Join::WITH, 'a.day = d')
                ->innerJoin(TypeAttendance::class, 't', Join::WITH, 'a.typeAttendance = t')
                ->innerJoin(SchoolClass::class, 'c', Join::WITH, 's.class = c')
                ->innerJoin(Grade::class, 'g', Join::WITH, 'c.grade = g')
                ->innerJoin(SchoolYear::class, 'y', Join::WITH, 'g.schoolYear = y')
                ->innerJoin(TypeClass::class, 'q', Join::WITH, 'c.typeClass = q')
                ->andWhere('y.actual = :year')
                ->setParameter('year', $this::ACTUAL)
                ->andWhere('d.id = :day')
                ->setParameter('day', $this->dayID)
                ->andWhere('q.id = :typeClass')
                ->setParameter('typeClass', $this->typeClassID)
                ->andWhere('g.id = :grade')
                ->setParameter('grade', $this->gradeID);
        }


        return $qb;
    }

}