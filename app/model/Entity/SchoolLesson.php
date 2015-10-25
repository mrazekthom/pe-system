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

}