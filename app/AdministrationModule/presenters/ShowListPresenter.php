<?php

namespace App\AdministrationModule\Presenters;

use App\Components\IClassListFactory;
use App\Components\IGradeListFactory;
use App\Components\IStudentListFactory;
use App\Model\Entity\Grade;
use App\Model\Entity\TypeClass;


/**
 * ShowList presenter for rendering Grade, Class, Student list
 */
class ShowListPresenter extends BaseAdministrationPresenter
{

    /** @var  IStudentListFactory @inject */
    public $studentList;

    /** @var  IClassListFactory @inject */
    public $classList;

    /** @var IGradeListFactory @inject */
    public $gradeList;


    public function renderGrade(Grade $grade)
    {
    }

    public function renderClass(Grade $grade, TypeClass $typeClass)
    {
    }

    public function createComponentGradeList()
    {
        return $this->gradeList->create();
    }

    public function createComponentClassList()
    {
        return $this->classList->create($this->getParameter('grade'));
    }

    public function createComponentStudentList()
    {
        return $this->studentList->create($this->getParameter('grade'), $this->getParameter('typeClass'));
    }


}
