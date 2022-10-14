<?php

/**
 * TOBENTO
 *
 * @copyright   Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Tag;

/**
 * HasTag
 */
trait HasTag
{
    /**
     * @var Tag
     */
    protected Tag $tag; 

    /**
     * Set the tag.
     *
     * @param Tag $tag
     * @return static $this
     */
    public function setTag(Tag $tag): static
    {
        $this->tag = $tag;
        return $this;
    }
        
    /**
     * Returns the tag.
     *
     * @return Tag
     */
    public function tag(): Tag
    {
        return $this->tag;
    }
}