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
use Nette\Utils\Strings;

class StudentQuery extends QueryObject
{

    CONST ACTUAL = 1;

    private $typeClass = NULL;
    private $grade = NULL;
    private $educationDay = NULL;

    public function setClass($class)
    {
        $this->grade = Strings::match($class, '~[0-9]~')[0];
        $this->typeClass = Strings::match($class, '~[A-Z]~')[0];
    }

    public function setEducationDay($day)
    {
        $this->educationDay = $day; //TODO: security type day
    }

    public function setGrade($grade)
    {
        $this->grade = Strings::match($grade, '~[0-9]~')[0];
    }

    public function getActualDay()
    {
        $this->educationDay = date('l');
    }


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

        if ($this->typeClass) {
            $qb->andWhere('t.class = :typeClass')
                ->setParameter('typeClass', $this->typeClass);
        }
        if ($this->grade) {
            $qb->andWhere('g.grade = :grade')
                ->setParameter('grade', $this->grade);
        }
        if ($this->educationDay) {
            $qb->andWhere('c.educationDay = :educationDay')
                ->setParameter('educationDay', $this->educationDay);
        }

        return $qb;
    }

}