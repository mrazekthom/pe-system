<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class Grade
{
    use MagicAccessors;
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;


    /**
     * @ORM\Column(type="integer")
     */
    protected $grade;

    /**
     * @return int
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param int $grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
    }


    /**
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $schoolYear;

    /**
     * @return SchoolYear
     */
    public function getSchoolYear()
    {
        return $this->schoolYear;
    }

    /**
     * @param SchoolYear $schoolYear
     */
    public function setSchoolYear(SchoolYear $schoolYear)
    {
        $this->schoolYear = $schoolYear;
    }

}