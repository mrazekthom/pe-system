<?php

namespace App\Components;


use App\Model\Entity\Grade;
use App\Model\EntityService\GradeQuery;
use Doctrine\ORM\EntityManager;

interface IGradeListFactory
{

    /**
     * @return GradeList
     */
    public function create();

}

/**
 * Class GradeList
 * @package App\Components
 */
class GradeList extends BaseComponent
{

    /** @var EntityManager */
    private $entityManager;


    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function render()
    {
        $query = new GradeQuery();
        $this->template->grades = $this->entityManager->getRepository(Grade::class)->fetch($query);
        $this->template->render();
    }
}