<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Discipline
{

    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\Column(type="string")
     */
    protected $discipline;

    /**
     * @ORM\ManyToOne(targetEntity="MainDiscipline")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $parents;

}