<?php

namespace App\Model\EntityService;

use App\Model\Entity\Grade;
use App\Model\Entity\SchoolClass;
use App\Model\Entity\SchoolYear;
use Doctrine\ORM\Query\Expr\Join;
use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;

class ClassQuery extends QueryObject
{

    CONST ACTUAL = 1;

    public $gradeID;

    public function setGrade(Grade $grade)
    {
        $this->gradeID = $grade->id;
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
            ->innerJoin(SchoolYear::class, 'y', Join::WITH, 'g.schoolYear = y')
            ->andWhere('y.actual = :year')
            ->setParameter('year', $this::ACTUAL)
            ->andWhere('g.id = :grade')
            ->setParameter('grade', $this->gradeID);

        return $qb;
    }

}