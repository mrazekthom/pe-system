<?php

namespace App\AdministrationModule\Presenters;

use App\Model\Entity\Student;
use App\Model\EntityService\StudentQuery;


/**
 * Homepage presenter for Administration Module.
 */
class HomepagePresenter extends BaseAdministrationPresenter
{

    /**
     * @inject
     * @var \Kdyby\Doctrine\EntityManager
     */
    public $EM;

    /** @var StudentQuery @inject */
    public $SQ;

    public function renderDefault()
    {
        //Only for testing
        $query = new StudentQuery();
        $query->setClass('4A');
        $result = $this->EM->getRepository(Student::class)->fetch($query);
        $foo = $result;
        foreach ($foo as $bar) {
            dump($bar);
        }

        exit();
        //Only for testing
    }


}
