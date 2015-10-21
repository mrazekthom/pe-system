<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class Student
{
    use MagicAccessors;
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;


    /**
     * @ORM\ManyToOne(targetEntity="SchoolClass")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $class;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $surname;

}