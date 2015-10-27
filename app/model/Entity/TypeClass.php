<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class TypeClass
{
    use MagicAccessors;
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;


    /**
     * @ORM\Column(type="string")
     */
    protected $class;

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }


}