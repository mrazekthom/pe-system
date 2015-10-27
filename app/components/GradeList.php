<?php

namespace App\Components;


use App\Model\Entity\SchoolClass;
use App\Model\EntityService\GradeQuery;
use Doctrine\ORM\EntityManager;

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
        $this->template->classes = $this->entityManager->getRepository(SchoolClass::class)->fetch($query);
        $this->template->render();
    }
}

interface IGradeListFactory
{

    /**
     * @return GradeList
     */
    public function create();

}