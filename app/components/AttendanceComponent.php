<?php

namespace App\Components;


use App\Model\Entity\Grade;
use App\Model\Entity\TypeClass;
use App\Model\Service\AttendanceService;
use App\Model\Service\AttendanceTypeService;
use App\Model\Service\WriteAttendanceService;
use Nette\Application\UI\Form;

interface IAttendanceFactory
{

    /**
     * @param Grade     $grade
     * @param TypeClass $typeClass
     * @return Attendance
     */
    public function create(Grade $grade, TypeClass $typeClass);

}

/**
 * Class Attendance
 * @package App\Components
 */
class Attendance extends BaseComponent
{

    /** @var  Grade */
    private $grade;

    /** @var  TypeClass */
    private $typeClass;

    /** @var  AttendanceTypeService */
    private $AttendanceTypeService;

    /** @var  WriteAttendanceService */
    private $writeAttendanceService;


    public function __construct(Grade $grade, TypeClass $typeClass, AttendanceTypeService $AttendanceTypeService, WriteAttendanceService $writeAttendanceService)
    {
        $this->grade = $grade;
        $this->typeClass = $typeClass;
        $this->AttendanceTypeService = $AttendanceTypeService;
        $this->writeAttendanceService = $writeAttendanceService;
    }

    public function render()
    {
        $this->template->render();
    }

    public function createComponentAddNewAttendance()
    {
        $attendanceTypes = $this->AttendanceTypeService->getAllAttendanceType();

        $form = new Form();
        $form->addSelect('attendanceType', 'Většina žáků má účast: ', $attendanceTypes);
        $form->addDatePicker('day');
        $form->addSubmit('add', 'Podrobný zápis účasti');
        $form->onSuccess[] = [$this, 'AddNewAttendanceFormSuccess'];
        return $form;
    }

    public function AddNewAttendanceFormSuccess(Form $form, $values)
    {
        if (!$values->day) {
            $this->redirect('this');
        }

        $day = $this->writeAttendanceService->writeAttendanceToDB($this->grade,
            $this->typeClass,
            $values->day,
            $values->attendanceType);
        $this->presenter->redirect('Attendance:edit', ['grade' => $this->grade, 'typeClass' => $this->typeClass, 'day' => $day]);
    }


}