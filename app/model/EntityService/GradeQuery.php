<?php

namespace App\Model\EntityService;

use App\Model\Entity\Grade;
use App\Model\Entity\SchoolYear;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;
use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;

class GradeQuery extends QueryObject
{

    CONST ACTUAL = 1;

    private $migrate;
    private $grade;

    public function setModeMigrationStudent($migrate = TRUE)
    {
        $this->migrate = $migrate;
    }

    public function setGrade($grade)
    {
        $this->grade = $grade;
    }

    /**
     * @param \Kdyby\Persistence\Queryable $repository
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    protected function doCreateQuery(Queryable $repository)
    {
        $qb = $repository->createQueryBuilder()
            ->select('g')->from(Grade::class, 'g')
            ->innerJoin(SchoolYear::class, 'y', Join::WITH, 'g.schoolYear = y')
            ->orderBy('g.grade', 'ASC')
            ->andWhere('y.actual = :year')
            ->setParameter('year', $this::ACTUAL);

        if ($this->migrate) {
            $qb->andWhere('g.grade != :grade')
                ->setParameter('grade', 4);
        }

        if ($this->grade) {
            $qb->andWhere('g.grade = :grade')
                ->setParameter('grade', $this->grade);
        }

        return $qb;
    }

}