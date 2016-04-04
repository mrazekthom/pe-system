<?php

namespace App\Components;


use App\Model\Service\AttendanceService;
use App\Model\Service\AttendanceTypeService;
use Nette\Application\UI\Form;

interface IAttendanceTypeFactory
{

    /**
     * @return AttendanceType
     */
    public function create();

}

/**
 * Class AttendanceType
 * @package App\Components
 */
class AttendanceType extends BaseComponent
{

    /** @var  AttendanceTypeService */
    private $AttendanceTypeService;

    public function __construct(AttendanceTypeService $AttendanceTypeService)
    {
        $this->AttendanceTypeService = $AttendanceTypeService;
    }

    public function render()
    {
        $this->template->render();
    }

    public function createComponentAddNewAttendanceType()
    {
        $form = new Form();
        $form->addText('attendanceType', 'Typ účasti: ')
            ->addRule(Form::PATTERN, 'musí být ve slovním tvaru (např. přítomen)', '([a-žA-Ž ]*)')
            ->setRequired();
        $form->addText('attendancePercent', 'Procentualní přítomnost (100 - plná účast, 0 - žádná účast): ')
            ->addRule(Form::PATTERN, 'Musí být ve tvaru hh:mm', '([0-9]){1,3}')
            ->setRequired();
        $form->addSubmit('add', 'Přidat typ absence');
        $form->onSuccess[] = [$this, 'AddNewAttendanceTypeFormSuccess'];
        return $form;
    }

    public function AddNewAttendanceTypeFormSuccess(Form $form, $values)
    {
        $this->AttendanceTypeService->addNewAttendanceType($values->attendanceType, $values->attendancePercent);
        $this->redirect('this');
    }


}