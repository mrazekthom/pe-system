<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Day
{
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;


    /**
     * @ORM\Column(type="date")
     */
    protected $day;

    /**
     * @return /Datetime
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param /Datetime $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

}