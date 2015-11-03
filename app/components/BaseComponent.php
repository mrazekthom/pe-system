<?php

namespace App\Components;

use App\Misc\FilterLoader;
use Nette\Application\UI\Control;
use Nette\Utils\Strings;

abstract class BaseComponent extends Control
{

    /** @var  FilterLoader */
    protected $filterLoader;
    private $view;

    /**
     * @param FilterLoader $filterLoader
     */
    public function injectFilterLoader(FilterLoader $filterLoader)
    {
        $this->filterLoader = $filterLoader;
    }

    public function render()
    {
        $this->template->render();
    }

    public function __call($name, $args)
    {
        if (Strings::match($name, '/(render)[A-Za-z]+/')) {
            $this->view = substr(Strings::lower($name), 6);
            return call_user_func($this->render);
        } else {
            return parent::__call($name, $args);
        }
    }

    /**
     * adding views
     * @return \Nette\Application\UI\ITemplate
     */
    protected function createTemplate()
    {
        $template = $this->filterLoader->loadFilters(parent::createTemplate());
        $dir = $this->presenter->context->parameters['appDir'];
        $name = $this->reflection->shortName;
        if ($this->view) {
            $template->setFile("$dir/components/templates/$name/$this->view.latte");
        } else {
            $template->setFile("$dir/components/templates/$name.latte");
        }
        return $template;
    }

}