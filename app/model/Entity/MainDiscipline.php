<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class MainDiscipline extends \Kdyby\Doctrine\Entities\BaseEntity
{

    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\Column(type="string")
     */
    protected $mainDiscipline;

}