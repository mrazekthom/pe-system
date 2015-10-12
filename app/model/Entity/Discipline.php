<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Discipline extends \Kdyby\Doctrine\Entities\BaseEntity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    protected  $id;

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