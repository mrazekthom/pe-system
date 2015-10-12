<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Grade extends \Kdyby\Doctrine\Entities\BaseEntity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    protected  $id;

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