<?php

namespace App\Model\EntityService;

use App\Model\Entity\Grade;
use App\Model\Entity\SchoolClass;
use App\Model\Entity\SchoolYear;
use App\Model\Entity\TypeClass;
use Doctrine\ORM\Query\Expr\Join;
use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;

class ClassesQuery extends QueryObject
{

    CONST ACTUALYEAR = 1;

    private $gradeID;

    public function setGrade(Grade $grade)
    {
        $this->gradeID = $grade->getId();
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
            ->innerJoin(TypeClass::class, 't', Join::WITH, 'c.typeClass = t')
            ->andWhere('y.actual = :year')
            ->setParameter('year', $this::ACTUALYEAR)
            ->orderBy('g.grade', 'ASC')
            ->addOrderBy('t.class', 'ASC');

        if ($this->gradeID) {
            $qb->andWhere('g.id = :grade')
                ->setParameter('grade', $this->gradeID);
        }

        return $qb;
    }

}