<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class Grade
{
    use MagicAccessors;
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\Column(type="integer")
     */
    protected $grade;

    /**
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $schoolYear;


}