<?php

namespace App\AdminModule\Presenters;

use App\Components\ISchoolTimetableChangeFactory;
use App\Components\ISchoolTimetableFactory;


/**
 * SchoolTimetable presenter for Admin Module.
 */
class SchoolTimetablePresenter extends BaseAdminPresenter
{

    /** @var ISchoolTimetableFactory @inject */
    public $SchoolTimetable;

    /** @var  ISchoolTimetableChangeFactory @inject */
    public $SchoolTimetableChange;

    public function renderDefault()
    {
    }


    public function createComponentAddNewLesson()
    {
        return $this->SchoolTimetable->create();
    }

    public function createComponentEditLesson()
    {
        return $this->SchoolTimetableChange->create();
    }


}
