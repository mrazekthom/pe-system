<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Grade
{

    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $grade;

    /**
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $schoolYear;


}