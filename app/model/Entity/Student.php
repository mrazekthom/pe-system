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

    /**
     * @return SchoolClass
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param SchoolClass $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

}