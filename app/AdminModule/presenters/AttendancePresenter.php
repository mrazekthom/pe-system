<?php

namespace App\AdminModule\Presenters;

use App\Components\IAttendanceTypeChangeFactory;
use App\Components\IAttendanceTypeFactory;


/**
 * Attendance presenter for Admin Module.
 */
class AttendancePresenter extends BaseAdminPresenter
{

    /** @var IAttendanceTypeFactory @inject */
    public $AttendanceType;

    /** @var  IAttendanceTypeChangeFactory @inject */
    public $AttendanceTypeChange;

    public function renderDefault()
    {
    }


    public function createComponentAddNewAttendanceType()
    {
        return $this->AttendanceType->create();
    }

    public function createComponentEditAttendanceType()
    {
        return $this->AttendanceTypeChange->create();
    }


}
