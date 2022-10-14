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
 * NullTag
 */
class NullTag extends Tag
{
    /**
     * @var string
     */
    protected string $name = '';
    
    /**
     * Create a new NullTag.
     *
     * @param string|Stringable $html The tag html content.
     * @param null|int $level The level depth of the tag.
     */
    public function __construct(
        string|Stringable $html = '',
        protected null|int $level = null,
    ){
        parent::__construct(name: '', html: $html, level: $level);
    }
    
    /**
     * Returns a new instance with the specified name.
     *
     * @param string $name
     * @return static
     */    
    public function withName(string $name): static
    {
        $new = clone $this;
        $new->name = '';
        return $new;
    }

    /**
     * Returns the evaluated contents of the tag.
     *
     * @return string
     */
    public function render(): string
    {
        return $this->getHtml();
    }
    
    /**
     * Renders the opening tag.
     *
     * @return string
     */
    public function open(): string
    {
        return '';
    }

    /**
     * Renders the closing tag.
     *
     * @return string
     */
    public function close(): string
    {
        return '';
    }
}