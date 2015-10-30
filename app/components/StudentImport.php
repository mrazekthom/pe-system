<?php

namespace App\Components;


use Nette\Application\UI\Form;
use Nette\Utils\Strings;
use Tracy\Debugger;

/**
 * Class StudentImport
 * @package App\Components
 */
class StudentImport extends BaseComponent
{

    public function __construct()
    {
    }

    protected function createComponentImportFile(){
        $form = new Form();
        $form->addUpload('txt', 'TXT');
        $form->addSubmit('upload', 'UPLOAD');
        $form->onSuccess[] = array($this, 'importFileFormSucceeded');
        return $form;
    }

    public function importFileFormSucceeded(Form $form, $values){
        if (Strings::split($values['txt']->name, '/[.]/')[1] === 'txt'){
            $values['txt']->move(__DIR__ . '/../../upload/' . $values['txt']->name);
            $foos = (file(__DIR__ . '/../../upload/' . $values['txt']->name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
            dump($foos);
            foreach($foos as $foo){
                $student = Strings::split($foo, '/ /');
                dump($student);
            }
        }else{
            //TODO: warning for user
        }

        Debugger::barDump($values['txt']);
    }

    public function render()
    {
        $this->template->render();
    }
}

interface IStudentImportFactory
{

    /**
     * @return StudentImport
     */
    public function create();

}