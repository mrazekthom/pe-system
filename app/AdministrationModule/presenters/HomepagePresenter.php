<?php

namespace App\AdministrationModule\Presenters;

use App\Components\IListOfStudentsComponentFactory;


/**
 * Homepage presenter for Administration Module.
 */
class HomepagePresenter extends BaseAdministrationPresenter
{

    /** @var  IListOfStudentsComponentFactory @inject */
    public $ILOSCF;


    public function renderDefault()
    {

    }

    public function createComponentListOfStudents()
    {
        return $this->ILOSCF->create();
    }


}
