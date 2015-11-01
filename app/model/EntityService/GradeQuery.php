<?php

namespace App\Model\EntityService;

use App\Model\Entity\Grade;
use App\Model\Entity\SchoolClass;
use App\Model\Entity\SchoolYear;
use Doctrine\ORM\Query\Expr\Join;
use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;

class GradeQuery extends QueryObject
{

    CONST ACTUAL = 1;

    /**
     * @param \Kdyby\Persistence\Queryable $repository
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    protected function doCreateQuery(Queryable $repository)
    {
        $qb = $repository->createQueryBuilder()
            ->select('c')->from(SchoolClass::class, 'c')
            ->leftJoin(Grade::class, 'g', Join::WITH, 'c.grade = g')
            ->andWhere('c.id = g.id')
            ->orderBy('g.grade', 'ASC')
            ->innerJoin(SchoolYear::class, 'y', Join::WITH, 'g.schoolYear = y')
            ->andWhere('y.actual = :year')
            ->setParameter('year', $this::ACTUAL);

        return $qb;
    }

}