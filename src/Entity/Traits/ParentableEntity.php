<?php

namespace App\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Trait ParentableEntity
 *
 * @package App\Entity\Traits
 */
trait ParentableEntity
{
    /**
     * @var self
     */
    protected $parent;

    /**
     * @var ArrayCollection
     */
    protected $children;


    /**
     * Set parent
     *
     * @return $this
     */
    public function setParent($parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return self
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @return $this
     */
    public function addChild(self $child)
    {
        $child->setParent($this);
        
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     */
    public function removeChild(self $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }
}
