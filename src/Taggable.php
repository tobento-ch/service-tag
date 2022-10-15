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
     * @param TagInterface $tag
     * @return static $this
     */
    public function setTag(TagInterface $tag): static;
        
    /**
     * Returns the tag.
     *
     * @return TagInterface
     */
    public function tag(): TagInterface;
}