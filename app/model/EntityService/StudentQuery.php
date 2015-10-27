<?php

namespace App\Model\EntityService;

use App\Model\Entity\Grade;
use App\Model\Entity\SchoolClass;
use App\Model\Entity\SchoolYear;
use App\Model\Entity\Student;
use App\Model\Entity\TypeClass;
use Doctrine\ORM\Query\Expr\Join;
use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;

class StudentQuery extends QueryObject
{

    CONST ACTUAL = 1;

    private $typeClassID;
    private $gradeID;
    private $educationDay;

    public function setClass(Grade $grade, TypeClass $typeClass)
    {
        $this->gradeID = $grade->id;
        $this->typeClassID = $typeClass->id;
    }

    /**
     * public function setGrade($grade)
     * {
     * $this->grade = Strings::match($grade, '~[0-9]~');
     * }
     *
     * public function setEducationDay($day)
     * {
     * $this->educationDay = $day; //TODO: security type day
     * }
     *
     * public function getActualDay()
     * {
     * $this->educationDay = date('l');
     * }
     */

    /**
     * @param \Kdyby\Persistence\Queryable $repository
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    protected function doCreateQuery(Queryable $repository)
    {
        $qb = $repository->createQueryBuilder()
            ->select('s')->from(Student::class, 's')
            ->innerJoin(SchoolClass::class, 'c', Join::WITH, 's.class = c')
            ->innerJoin(Grade::class, 'g', Join::WITH, 'c.grade = g')
            ->innerJoin(SchoolYear::class, 'y', Join::WITH, 'g.schoolYear = y')
            ->innerJoin(TypeClass::class, 't', Join::WITH, 'c.typeClass = t')
            ->andWhere('y.actual = :year')
            ->setParameter('year', $this::ACTUAL);

        if ($this->typeClassID) {
            $qb->andWhere('t.id = :typeClass')
                ->setParameter('typeClass', $this->typeClassID);
        }
        if ($this->gradeID) {
            $qb->andWhere('g.id = :grade')
                ->setParameter('grade', $this->gradeID);
        }
        /**if ($this->educationDay) {
         * $qb->andWhere('c.educationDay = :educationDay')
         * ->setParameter('educationDay', $this->educationDay);
         * }*/

        return $qb;
    }

}