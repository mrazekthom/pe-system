<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class StudentResult
{
    use MagicAccessors;
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $student;

    /**
     * @ORM\ManyToOne(targetEntity="Sport")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $sport;

    /**
     * @ORM\Column(type="float")
     */
    protected $result;

    /**
     * @ORM\ManyToOne(targetEntity="Unit")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $unit;

    /**
     * @ORM\ManyToOne(targetEntity="SupposedResult")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $supposedResult;

}