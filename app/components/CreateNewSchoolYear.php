<?php

namespace App\Components;

use App\Model\Service\CreateNewSchoolYearService;
use Kdyby\Doctrine\EntityManager;
use Nette\Application\UI\Form;


interface ICreateNewSchoolYearFactory
{

    /**
     * @return CreateNewSchoolYear
     */
    public function create();

}

/**
 * Class CreateNewSchoolYear
 * @package App\Components
 */
class CreateNewSchoolYear extends BaseComponent
{

    /** @var EntityManager */
    private $entityManager;


    private $createNewSchoolYearService;

    /**
     * @param EntityManager              $entityManager
     * @param CreateNewSchoolYearService $createNewSchoolYearService
     */
    public function __construct(EntityManager $entityManager, CreateNewSchoolYearService $createNewSchoolYearService)
    {
        $this->entityManager = $entityManager;
        $this->createNewSchoolYearService = $createNewSchoolYearService;
    }

    public function render()
    {
        $this->template->render();
    }

    public function createComponentNewYearForm()
    {
        $form = new Form();
        $form->addText('year', 'Začátek školního roku: ')
            ->setDefaultValue(date('o'))
            ->addRule(Form::INTEGER, 'Musí být rok ve správném tvaru.')
            ->addRule(Form::RANGE, 'Musí být tento, nebo následující rok.', array(date('o') - 1, date('o') + 2))
            ->setRequired();
        $form->addCheckbox('migrate', 'Přenést žáky z minulého roku?')
            ->setDefaultValue(True);
        $form->addSubmit('create', 'Vytvořit');
        $form->onSuccess[] = [$this, 'newYearFormSuccess'];
        return $form;
    }

    public function newYearFormSuccess(Form $form, $values)
    {
        $this->createNewSchoolYearService->createNewYear($values->year, $values->migrate);
        $this->redirect('this');
    }

}