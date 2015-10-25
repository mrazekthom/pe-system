<?php

namespace App\AdministrationModule\Presenters;

use App\Components\IStudentListFactory;


/**
 * Homepage presenter for Administration Module.
 */
class HomepagePresenter extends BaseAdministrationPresenter
{

    /** @var  IStudentListFactory @inject */
    public $studentList;


    public function renderDefault()
    {

    }

    public function createComponentListOfStudents()
    {
        return $this->studentList->create();
    }


}
