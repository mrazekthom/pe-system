<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class SchoolClass
{
    use MagicAccessors;
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;


    /**
     * @ORM\ManyToOne(targetEntity="Grade")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $grade;

    /**
     * @return Grade
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param Grade $grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
    }


    /**
     * @ORM\ManyToOne(targetEntity="TypeClass")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $typeClass;

    /**
     * @return TypeClass
     */
    public function getTypeClass()
    {
        return $this->typeClass;
    }

    /**
     * @param TypeClass $typeClass
     */
    public function setTypeClass($typeClass)
    {
        $this->typeClass = $typeClass;
    }


    /**
     * @ORM\OneToMany(targetEntity="EducationDay", mappedBy="schoolClass")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $educationDay;

    /**
     * @return EducationDay
     */
    public function getEducationDay()
    {
        return $this->educationDay;
    }

    /**
     * @param EducationDay $educationDay
     */
    public function setEducationDay($educationDay)
    {
        $this->educationDay = $educationDay;
    }


}