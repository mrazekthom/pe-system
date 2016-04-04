<?php

namespace App\Model\EntityService;

use App\Model\Entity\TypeClass;
use Kdyby\Doctrine\QueryObject;
use Kdyby\Persistence\Queryable;

class TypeClassQuery extends QueryObject
{

    private $typeClass;

    public function setTypeClass($typeClass)
    {
        $this->typeClass = $typeClass;
    }

    /**
     * @param \Kdyby\Persistence\Queryable $repository
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    protected function doCreateQuery(Queryable $repository)
    {
        $qb = $repository->createQueryBuilder()
            ->select('c')->from(TypeClass::class, 'c')
            ->where('c.class = :typeClass')
            ->setParameter('typeClass', $this->typeClass);

        return $qb;
    }

}