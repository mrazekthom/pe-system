<?php

namespace App\AdminModule\Presenters;
use App\Components\IStudentImportFactory;


/**
 * Homepage presenter for Admin Module.
 */
class HomepagePresenter extends BaseAdminPresenter
{

    /** @var IStudentImportFactory @inject */
    public $studentImport;

    public function renderDefault()
    {
    }


    public function createComponentStudentImport(){
        return $this->studentImport->create();
    }


    public function createComponentEditSchoolTimetable(){

    }

}
