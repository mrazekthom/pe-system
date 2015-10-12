<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SchoolYear extends \Kdyby\Doctrine\Entities\BaseEntity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    protected  $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $start;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $end;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $actual;

}