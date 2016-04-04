<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class SchoolLesson
{
    use MagicAccessors;
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\Column(type="integer")
     */
    protected $lesson;
    /**
     * @ORM\Column(type="time")
     */
    protected $start;
    /**
     * @ORM\Column(type="time")
     */
    protected $end;

    /**
     * @return int
     */
    public function getLesson()
    {
        return $this->lesson;
    }

    /**
     * @param int $lesson
     */
    public function setLesson($lesson)
    {
        $this->lesson = $lesson;
    }

    /**
     * @return \Datetime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param \Datetime $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return \Datetime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param \Datetime $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }


}