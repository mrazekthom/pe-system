<?php

namespace App\Model\EntityService;

use App\Model\Entity\SchoolLesson;
use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;

class SchoolLessonQuery extends QueryObject
{

    CONST ACTUAL = 1;

    /**
     * @param \Kdyby\Persistence\Queryable $repository
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    public function doCreateQuery(Queryable $repository)
    {
        $qb = $repository->createQueryBuilder()
            ->select('s')->from(SchoolLesson::class, 's');

        return $qb;
    }

}