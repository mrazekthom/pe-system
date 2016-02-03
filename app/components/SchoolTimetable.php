<?php

namespace App\Components;


use App\Model\Service\SchoolTimetableService;

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


}