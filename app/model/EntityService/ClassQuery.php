<?php

namespace App\Model\EntityService;

use App\Model\Entity\Grade;
use App\Model\Entity\SchoolClass;
use App\Model\Entity\SchoolYear;
use App\Model\Entity\TypeClass;
use Doctrine\ORM\Query\Expr\Join;
use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;

class ClassQuery extends QueryObject
{

    CONST ACTUAL = 1;

    private $grade;

    private $typeClass;

    public function setClass($grade, $typeClass)
    {
        $this->grade = $grade;
        $this->typeClass = $typeClass;
    }

    /**
     * @param \Kdyby\Persistence\Queryable $repository
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    protected function doCreateQuery(Queryable $repository)
    {
        $qb = $repository->createQueryBuilder()
            ->select('c')->from(SchoolClass::class, 'c')
            ->innerJoin(Grade::class, 'g', Join::WITH, 'c.grade = g')
            ->innerJoin(TypeClass::class, 't', Join::WITH, 'c.typeClass = t')
            ->innerJoin(SchoolYear::class, 'y', Join::WITH, 'g.schoolYear = y')
            ->andWhere('y.actual = :year')
            ->setParameter('year', $this::ACTUAL)
            ->andWhere('g.grade = :grade')
            ->setParameter('grade', $this->grade)
            ->andWhere('t.class = :typeClass')
            ->setParameter('typeClass', $this->typeClass);

        return $qb;
    }

}