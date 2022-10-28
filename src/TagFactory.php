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

use Stringable;

/**
 * TagFactory
 */
class TagFactory implements TagFactoryInterface
{
    /**
     * Create a new tag.
     *
     * @param string $name The tag name such as 'li'.
     * @param string|Stringable $html The tag html content.
     * @param null|AttributesInterface $attributes
     * @param null|int $level The level depth of the tag.
     * @return TagInterface
     * @throws CreateTagException
     */
    public function createTag(
        string $name,
        string|Stringable $html = '',
        null|AttributesInterface $attributes = null,
        null|int $level = null
    ): TagInterface {
        return new Tag(
            name: $name,
            html: $html,
            attributes: $attributes,
            level: $level,
        );
    }
    
    /**
     * Create a new Tag from the specified html.
     *
     * @param string|Stringable $html
     * @return TagInterface
     * @throws CreateTagException
     */
    public function createTagFromHtml(string|Stringable $html): TagInterface
    {
        return new NullTag($html);
    }
}