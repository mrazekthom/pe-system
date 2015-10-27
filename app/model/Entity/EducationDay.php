<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class EducationDay
{
    use MagicAccessors;
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\ManyToOne(targetEntity="TypeDay")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $typeDay;

    /**
     * @ORM\ManyToOne(targetEntity="SchoolLesson")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $schoolLesson;

    /**
     * @ORM\ManyToOne(targetEntity="SchoolClass", inversedBy="educationDay")
     * @ORM\JoinColumn(name="school_class_id", referencedColumnName="id")
     */
    protected $schoolClass; //TODO: nullable:false

}