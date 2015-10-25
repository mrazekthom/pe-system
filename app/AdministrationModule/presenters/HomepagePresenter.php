<?php

namespace App\AdministrationModule\Presenters;

use App\Components\IStudentListFactory;
use App\Model\Entity\Student;
use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\Grade;
use App\Model\Entity\TypeClass;


/**
 * Homepage presenter for Administration Module.
 */
class HomepagePresenter extends BaseAdministrationPresenter
{

    /** @var  IStudentListFactory @inject */
    public $studentList;

    /** @var  EntityManager @inject */
    public $EM;


    public function renderDefault()
    {


    }

    public function createComponentStudentList()
    {
        return $this->studentList->create($this->EM->find(Grade::class, 2), $this->EM->find(TypeClass::class, 1));
    }


}
