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
 * TagInterface
 */
interface TagInterface extends Stringable
{
    /**
     * Returns the tag name.
     *
     * @return string
     */
    public function getName(): string;
    
    /**
     * Returns a new instance with the specified name.
     *
     * @param string $name
     * @return static
     */    
    public function withName(string $name): static;
    
    /**
     * Returns the html.
     *
     * @return string
     */
    public function getHtml(): string;
    
    /**
     * Returns a new instance with the specified html.
     *
     * @param string|Stringable $html
     * @return static
     */    
    public function withHtml(string|Stringable $html): static;
    
    /**
     * Returns the level depth of the tag.
     *
     * @return null|int
     */
    public function getLevel(): null|int;
    
    /**
     * Returns a new instance with the specified level.
     *
     * @param int $level
     * @return static
     */    
    public function withLevel(int $level): static;
    
    /**
     * Returns the attributes.
     *
     * @return AttributesInterface
     */
    public function attributes(): AttributesInterface;
    
    /**
     * Returns a new instance with the specified attributes.
     *
     * @param AttributesInterface $attributes
     * @return static
     */
    public function withAttributes(AttributesInterface $attributes): static;
    
    /**
     * Returns the evaluated contents of the tag.
     *
     * @return string
     */
    public function render(): string;
    
    /**
     * Renders the opening tag.
     *
     * @return string
     */
    public function open(): string;

    /**
     * Renders the closing tag.
     *
     * @return string
     */
    public function close(): string;
    
    /**
     * Returns true if the tag is selfclosing, otherwise false.
     *
     * @return bool
     */
    public function isSelfClosing(): bool;
    
    /**
     * Prepend html.
     *
     * @param string|Stringable $html
     * @return static $this
     */
    public function prepend(string|Stringable $html): static;
    
    /**
     * Append html.
     *
     * @param string|Stringable $html
     * @return static $this
     */
    public function append(string|Stringable $html): static;

    /**
     * Set an attribute to the attributes.
     *
     * @param string $name
     * @param mixed $value
     * @return static $this
     */
    public function attr(string $name, mixed $value = null): static;
    
    /**
     * Add a class to the attributes.
     *
     * @param string $value
     * @return static $this
     */
    public function class(string $value): static;
}