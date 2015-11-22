<?php

namespace App\AdminModule\Presenters;

use App\Components\ICreateNewSchoolYearFactory;


/**
 * NewSchoolYear presenter for Admin Module.
 */
class NewSchoolYearPresenter extends BaseAdminPresenter
{

    /** @var ICreateNewSchoolYearFactory @inject */
    public $createNewSchoolYear;

    public function renderDefault()
    {
    }


    public function createComponentCreateNewSchoolYear()
    {
        return $this->createNewSchoolYear->create();
    }


}
