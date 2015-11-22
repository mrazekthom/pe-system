<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class SchoolYear
{
    use MagicAccessors;
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $start;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $end;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $actual;

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @return bool
     */
    public function getActual()
    {
        return $this->actual;
    }

    /**
     * @param bool $actual
     */
    public function setActual($actual)
    {
        $this->actual = $actual;
    }
}