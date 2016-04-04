<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class Attendance
{
    use MagicAccessors;
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $student;
    /**
     * @ORM\ManyToOne(targetEntity="Day")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $day;
    /**
     * @ORM\ManyToOne(targetEntity="TypeAttendance")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $typeAttendance;

    /**
     * @return Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param Student $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

    /**
     * @return Day
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param Day $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @return TypeAttendance
     */
    public function getTypeAttendance()
    {
        return $this->typeAttendance;
    }

    /**
     * @param TypeAttendance $typeAttendance
     */
    public function setTypeAttendance($typeAttendance)
    {
        $this->typeAttendance = $typeAttendance;
    }

}