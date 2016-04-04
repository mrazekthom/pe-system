<?php

namespace App\Components;


use App\Model\Service\SchoolTimetableService;
use Nette\Application\UI\Form;

interface ISchoolTimetableFactory
{

    /**
     * @return SchoolTimetable
     */
    public function create();

}

/**
 * Class SchoolTimetable
 * @package App\Components
 */
class SchoolTimetable extends BaseComponent
{

    /** @var  SchoolTimetableService */
    private $schoolTimetableService;

    public function __construct(SchoolTimetableService $schoolTimetableService)
    {
        $this->schoolTimetableService = $schoolTimetableService;
    }

    public function render()
    {
        $this->template->render();
    }

    public function createComponentAddNewSchoolLesson()
    {
        $form = new Form();
        $form->addText('schoolLesson', 'Hodina číslo: ')
            ->addRule(Form::PATTERN, 'musí být ve tvaru hh:mm', '([0-9]){1,2}')
            ->setRequired();
        $form->addText('schoolLessonStart', 'Začátek hodiny: ')
            ->addRule(Form::PATTERN, 'Musí být ve tvaru hh:mm', '([0-9]){1,2}(:)([0-9]){2}')
            ->setRequired();
        $form->addText('schoolLessonEnd', 'Konec hodiny: ')
            ->addRule(Form::PATTERN, 'Musí být ve tvaru hh:mm', '([0-9]){1,2}(:)([0-9]){2}')
            ->setRequired();
        $form->addSubmit('add', 'Přidat školní hodinu');
        $form->onSuccess[] = [$this, 'addNewSchoolLessonFormSuccess'];
        return $form;
    }

    public function addNewSchoolLessonFormSuccess(Form $form, $values)
    {
        $this->schoolTimetableService->addNewSchoolLesson(
            $values->schoolLesson,
            date('H:i:s', mktime(
                explode(":", $values->schoolLessonStart)[0],
                explode(":", $values->schoolLessonStart)[1],
                00)),
            date('H:i:s', mktime(
                explode(":", $values->schoolLessonEnd)[0],
                explode(":", $values->schoolLessonEnd)[1],
                00)));
        $this->redirect('this');
    }


}