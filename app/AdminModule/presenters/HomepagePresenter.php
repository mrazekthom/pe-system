<?php

namespace App\AdminModule\Presenters;
use App\Components\IStudentImportFactory;
use App\Model\Entity\Student;


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


}
