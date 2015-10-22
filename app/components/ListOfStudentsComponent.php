<?php

namespace App\Components;


use App\Model\Service\StudentService;

class ListOfStudentsComponent extends BaseComponent
{

    private $SS;

    public function __construct(StudentService $SS)
    {
        $this->SS = $SS;
    }

    public function render()
    {
        $this->template->students = $this->SS->getStudentFromClass('3A');
        $this->template->render();
    }
}

interface IListOfStudentsComponentFactory
{

    /**
     * @return ListOfStudentsComponent
     */
    public function create();

}