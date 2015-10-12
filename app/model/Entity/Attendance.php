<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Attendance extends \Kdyby\Doctrine\Entities\BaseEntity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    protected  $id;

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

}