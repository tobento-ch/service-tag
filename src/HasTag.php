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
     * @var TagInterface
     */
    protected TagInterface $tag; 

    /**
     * Set the tag.
     *
     * @param TagInterface $tag
     * @return static $this
     */
    public function setTag(TagInterface $tag): static
    {
        $this->tag = $tag;
        return $this;
    }
        
    /**
     * Returns the tag.
     *
     * @return TagInterface
     */
    public function tag(): TagInterface
    {
        return $this->tag;
    }
}