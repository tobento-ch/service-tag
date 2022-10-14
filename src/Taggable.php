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
 * Taggable
 */
interface Taggable
{
    /**
     * Set the tag.
     *
     * @param Tag $tag
     * @return static $this
     */
    public function setTag(Tag $tag): static;
        
    /**
     * Returns the tag.
     *
     * @return Tag
     */
    public function tag(): Tag;
}