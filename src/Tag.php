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
 * Tag
 */
class Tag implements TagInterface
{
    /**
     * @var array<int, string>
     */
    protected const SELF_CLOSING_TAGS = [
        'area', 'br', 'col', 'embed', 'hr', 'img', 'input',
        'link', 'meta', 'param', 'source', 'track', 'wbr',
    ];

    /**
     * @var string The html.
     */
    protected string $html = '';
    
    /**
     * @var AttributesInterface
     */
    protected AttributesInterface $attributes;
    
    /**
     * @var string The html to prepend.
     */
    protected string $prepend = '';

    /**
     * @var string The html to append.
     */
    protected string $append = '';
        
    /**
     * Create a new Tag.
     *
     * @param string $name The tag name such as 'li'.
     * @param string|Stringable $html The tag html content.
     * @param null|AttributesInterface $attributes
     * @param null|int $level The level depth of the tag.
     * @param bool $renderEmptyTag
     */
    public function __construct(
        protected string $name,
        string|Stringable $html = '',
        null|AttributesInterface $attributes = null,
        protected null|int $level = null,
        protected bool $renderEmptyTag = true
    ){
        $this->html = (string)$html;
        $this->attributes = $attributes ?: new Attributes();
    }

    /**
     * Returns the tag name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
        $new->name = $name;
        return $new;
    }
    
    /**
     * Returns the html.
     *
     * @return string
     */
    public function getHtml(): string
    {
        return $this->prepend.$this->html.$this->append;
    }
    
    /**
     * Returns a new instance with the specified html.
     *
     * @param string|Stringable $html
     * @return static
     */    
    public function withHtml(string|Stringable $html): static
    {
        $new = clone $this;
        $new->html = (string)$html;
        return $new;
    }
    
    /**
     * Returns the level depth of the tag.
     *
     * @return null|int
     */
    public function getLevel(): null|int
    {
        return $this->level;
    }
    
    /**
     * Returns a new instance with the specified level.
     *
     * @param int $level
     * @return static
     */    
    public function withLevel(int $level): static
    {
        $new = clone $this;
        $new->level = $level;
        return $new;
    }
    
    /**
     * Returns the attributes.
     *
     * @return AttributesInterface
     */
    public function attributes(): AttributesInterface
    {
        return $this->attributes;
    }
    
    /**
     * Returns a new instance with the specified attributes.
     *
     * @param AttributesInterface $attributes
     * @return static
     */
    public function withAttributes(AttributesInterface $attributes): static
    {
        $new = clone $this;
        $new->attributes = $attributes;
        return $new;
    }
    
    /**
     * Returns a new instance with the specified attribute.
     *
     * @param string $name
     * @param mixed $value = null
     * @return static
     */
    public function withAttr(string $name, mixed $value = null): static
    {
        $new = clone $this;
        $new->attributes()->set($name, $value);
        return $new;
    }
    
    /**
     * Returns the evaluated contents of the tag.
     *
     * @return string
     */
    public function render(): string
    {
        if (!$this->renderEmptyTag && empty($this->getHtml())) {
            return '';
        }
        
        if ($this->isSelfClosing()) {
            return $this->open();
        }
        
        return $this->open().$this->getHtml().$this->close();
    }
    
    /**
     * Returns the string representation of the tag.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }
    
    /**
     * Renders the opening tag.
     *
     * @return string
     */
    public function open(): string
    {
        $name = Str::esc($this->name);

        return "<{$name}{$this->attributes()}>";
    }

    /**
     * Renders the closing tag.
     *
     * @return string
     */
    public function close(): string
    {
        $name = Str::esc($this->name);
        
        return "</{$name}>";
    }
    
    /**
     * Returns true if the tag is selfclosing, otherwise false.
     *
     * @return bool
     */
    public function isSelfClosing(): bool
    {
        return in_array($this->name, static::SELF_CLOSING_TAGS);
    }
    
    /**
     * Prepend html.
     *
     * @param string|Stringable $html
     * @return static $this
     */
    public function prepend(string|Stringable $html): static
    {
        $this->prepend .= (string)$html;
        return $this;
    }
    
    /**
     * Append html.
     *
     * @param string|Stringable $html
     * @return static $this
     */
    public function append(string|Stringable $html): static
    {
        $this->append .= (string)$html;
        return $this;
    }

    /**
     * Set an attribute to the attributes.
     *
     * @param string $name
     * @param mixed $value
     * @return static $this
     */
    public function attr(string $name, mixed $value = null): static
    {
        $this->attributes()->set($name, $value);
        return $this;
    }
    
    /**
     * Add a class to the attributes.
     *
     * @param string $value
     * @return static $this
     */
    public function class(string $value): static
    {
        $this->attributes()->add('class', $value);
        return $this;
    }
    
    /**
     * Clone: attributes.
     */
    public function __clone()
    {
        $this->attributes = clone $this->attributes();
    }
}