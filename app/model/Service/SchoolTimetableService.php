<?php

namespace App\Model\Service;

use App\Model\Entity\SchoolLesson;
use Kdyby\Doctrine\EntityManager;
use Nette\Utils\DateTime;

class SchoolTimetableService
{

    /** @var  EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addNewSchoolLesson($lessonNumber, $from, $to)
    {
        //TODO: lesson duration = 45 min!!!
        $newEntitySchoolLesson = new SchoolLesson();
        $newEntitySchoolLesson->setLesson($lessonNumber);
        $newEntitySchoolLesson->setStart(new DateTime($from));
        $newEntitySchoolLesson->setEnd(new DateTime($to));
        $this->entityManager->persist($newEntitySchoolLesson);
        $this->entityManager->flush();
    }

}