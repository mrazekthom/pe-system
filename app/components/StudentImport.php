<?php

namespace App\Components;


use App\Model\Service\StudentImportService;
use Nette\Application\UI\Form;
use Nette\Utils\Strings;
use Tracy\Debugger;

interface IStudentImportFactory
{

    /**
     * @return StudentImport
     */
    public function create();

}

/**
 * Class StudentImport
 * @package App\Components
 */
class StudentImport extends BaseComponent
{

    /** @var  StudentImportService */
    private $studentImportService;

    public function __construct(StudentImportService $studentImportService)
    {
        $this->studentImportService = $studentImportService;
    }

    public function importFileFormSucceeded(Form $form, $values){
        if (Strings::split($values['txt']->name, '/[.]/')[1] === 'txt'){
            $values['txt']->move(__DIR__ . '/../../upload/' . $values['txt']->name);
            $students = (file(__DIR__ . '/../../upload/' . $values['txt']->name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
            $this->studentImportService->decodeStudents($students);
        }else{
            //TODO: warning for user
        }

        Debugger::barDump($values['txt']);
    }

    public function render()
    {
        $this->template->render();
    }

    protected function createComponentImportFile()
    {
        $form = new Form();
        $form->addUpload('txt', 'TXT');
        $form->addSubmit('upload', 'UPLOAD');
        $form->onSuccess[] = array($this, 'importFileFormSucceeded');
        return $form;
    }
}