<?php

namespace App\AdministrationModule\Presenters;

use App\Components\IClassListFactory;
use App\Components\IGradeListFactory;
use App\Components\IStudentListFactory;
use Kdyby\Doctrine\EntityManager;


/**
 * Homepage presenter for Administration Module.
 */
class HomepagePresenter extends BaseAdministrationPresenter
{

    /** @var  IStudentListFactory @inject */
    public $studentList;

    /** @var  IClassListFactory @inject */
    public $classList;

    /** @var IGradeListFactory @inject */
    public $gradeList;

    /** @var  EntityManager @inject */
    public $EM;


    public function renderDefault()
    {
    }


}
