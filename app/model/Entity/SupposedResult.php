<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SupposedResult
{

    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

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