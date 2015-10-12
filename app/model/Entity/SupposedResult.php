<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SupposedResult extends \Kdyby\Doctrine\Entities\BaseEntity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    protected  $id;

    /**
     * @ORM\ManyToOne(targetEntity="Sport")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $sport;

    /**
     * @ORM\Column(type="integer")
     */
    protected $mark;

    /**
     * @ORM\Column(type="float")
     */
    protected $resultBetterThat;

    /**
     * @ORM\ManyToOne(targetEntity="Unit")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $unit;

}