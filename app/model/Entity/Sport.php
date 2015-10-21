<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class Sport
{
    use MagicAccessors;
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\ManyToOne(targetEntity="Grade")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $grade;

    /**
     * @ORM\ManyToOne(targetEntity="Discipline")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $discipline;

}