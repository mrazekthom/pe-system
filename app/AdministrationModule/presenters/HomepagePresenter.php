<?php

namespace App\AdministrationModule\Presenters;

use App\Model\Entity\Student;
use App\Model\EntityService\StudentQuery;


/**
 * Homepage presenter for Administration Module.
 */
class HomepagePresenter extends BaseAdministrationPresenter
{

    /** @var \Kdyby\Doctrine\EntityManager @inject */
    public $EM;

    public function renderDefault()
    {
        //Only for testing
        $query = new StudentQuery();
        $query->setEducationDay('Monday');
        $result = $this->EM->getRepository(Student::class)->fetch($query);
        $foo = $result;
        foreach ($foo as $bar) {
            dump($bar);
        }

        exit();
        //Only for testing
    }


}
