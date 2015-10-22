<?php

namespace App\Misc;

use Nette\Application\LinkGenerator;
use Nette\Application\UI\ITemplate;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\InvalidArgumentException;
use Nette\Object;

class FilterLoader extends Object
{

    /** @var LinkGenerator */
    private $linkGenerator;

    /**
     * @param LinkGenerator $linkGenerator
     */
    public function __construct(LinkGenerator $linkGenerator)
    {
        $this->linkGenerator = $linkGenerator;
    }


    /**
     * @param Template $template
     * @return Template
     */
    public function loadFilters(ITemplate $template)
    {
        if (!$template instanceof Template) {
            $type = $template->getReflection()->getName();
            throw new InvalidArgumentException("\$template have to be instance of Nette\\Bridges\\ApplicationLatte\\Template, '$type' given.");
        }

        return $template;
    }
}