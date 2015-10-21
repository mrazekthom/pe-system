<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class SchoolClass
{
    use MagicAccessors;
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\ManyToOne(targetEntity="Grade")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $grade;

    /**
     * @ORM\ManyToOne(targetEntity="TypeClass")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $typeClass;

    /**
     * @ORM\Column(type="string")
     */
    protected $educationDay;

}