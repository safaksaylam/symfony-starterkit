<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait SortableEntity
 *
 * @package App\Entity\Traits
 */
trait SortableEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position = 0;


    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }
}
