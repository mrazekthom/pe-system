<?php

namespace App\AdministrationModule\Presenters;

use App\Components\IAttendanceChangeFactory;
use App\Components\IAttendanceFactory;
use App\Components\IStudentAttendanceFactory;
use App\Components\IStudentListFactory;
use App\Components\IStudentListOfAttendanceFactory;
use App\Model\Entity\Day;
use App\Model\Entity\Grade;
use App\Model\Entity\TypeClass;


/**
 * Attendance presenter for rendering Grade, Class, Student list
 */
class AttendancePresenter extends BaseAdministrationPresenter
{

    /** @var  IStudentListFactory @inject */
    public $studentList;

    /** @var  IAttendanceFactory @inject */
    public $attendance;

    /** @var  IAttendanceChangeFactory @inject */
    public $attendanceChange;

    /** @var  IStudentListOfAttendanceFactory @inject */
    public $studentListOfAttendance;

    /** @var  IStudentAttendanceFactory @inject */
    public $studentAttendance;

    public function renderDefault(Grade $grade, TypeClass $typeClass)
    {
    }

    public function renderDetailAll(Grade $grade, TypeClass $typeClass)
    {
        $this->template->grade = $grade;
        $this->template->typeClass = $typeClass;
    }

    public function renderDetail($id)
    {

    }

    public function renderEdit(Grade $grade, TypeClass $typeClass, Day $day)
    {
        $this->template->grade = $grade;
        $this->template->typeClass = $typeClass;
    }

    public function createComponentStudentList()
    {
        return $this->studentList->create($this->getParameter('grade'), $this->getParameter('typeClass'));
    }

    public function createComponentWriteNewAttendance()
    {
        return $this->attendance->create($this->getParameter('grade'), $this->getParameter('typeClass'));
    }

    public function createComponentEditAttendance()
    {
        return $this->attendanceChange->create($this->getParameter('grade'), $this->getParameter('typeClass'), $this->getParameter('day'));
    }

    public function createComponentDetailAllAttendance()
    {
        return $this->studentListOfAttendance->create($this->getParameter('grade'), $this->getParameter('typeClass'));
    }

    public function createComponentDetailAttendance()
    {
        return $this->studentAttendance->create($this->getParameter('id'));
    }

}
