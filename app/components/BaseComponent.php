<?php

namespace App\Components;

use App\Misc\FilterLoader;
use Nette\Application\UI\Control;

abstract class BaseComponent extends Control
{
    /** @var  FilterLoader */
    protected $filterLoader;

    /**
     * @param FilterLoader $filterLoader
     */
    public function injectFilterLoader(FilterLoader $filterLoader)
    {
        $this->filterLoader = $filterLoader;
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
        $template->setFile("$dir/components/templates/$name.latte");
        return $template;
    }

}