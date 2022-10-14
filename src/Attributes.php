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
 * Attributes
 */
class Attributes implements Stringable
{
    /**
     * Create a new Attributes.
     *
     * @param array $attributes
     */
    public function __construct(
        protected array $attributes = [],
    ) {}
    
    /**
     * If attributes empty.
     *
     * @return bool
     */
    public function empty(): bool
    {
        return empty($this->attributes);
    }

    /**
     * If an attribute exists.
     *
     * @param string $name The name.
     * @return bool True if exist, else false.
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Get an attribute
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name): mixed
    {    
        return $this->attributes[$name] ?? null;
    }
    
    /**
     * Set an attribute.
     *
     * @param string $name
     * @param mixed $value
     * @return static $this
     */
    public function set(string $name, mixed $value = null): static
    {
        $this->attributes[$name] = $value;
        return $this;
    }
    
    /**
     * Add an attribute.
     *
     * @param string $name
     * @param mixed $value
     * @return static $this
     */
    public function add(string $name, mixed $value = null): static
    {
        if ($this->has($name)) {
            $this->set($name, array_merge(
                $this->ensureArray($this->get($name)),
                $this->ensureArray($value)
            ));
            
            return $this;
        }
        
        $this->set($name, $value);
        
        return $this;
    }
    
    /**
     * Merge attributes.
     *
     * @param array $attributes The attributes to merge
     * @return static $this
     */
    public function merge(array $attributes): static
    {
        foreach($attributes as $name => $value) {
            $this->add($name, $value);
        }
        
        return $this;
    }
    
    /**
     * Get all attributes.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->attributes;
    }
    
    /**
     * Returns the string representation of the attributes.
     * It must return an empty space at the beginning
     * if there are attributes, otherwise an empy string.
     *
     * @return string
     */
    public function render(): string
    {
        return Str::formatTagAttributes($this->all(), true);
    }
    
    /**
     * Returns the evaluated contents of the attributes
     * without and empty space at the beginning.
     *
     * @return string
     */
    public function renderWithoutSpace(): string
    {
        return Str::formatTagAttributes($this->all(), false);
    }
    
    /**
     * Returns the string representation of the attributes.
     * It must return an empty space at the beginning
     * if there are attributes, otherwise an empy string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Ensure array.
     * 
     * @param mixed $value The value
     * @return array
     */
    protected function ensureArray(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }
        
        return [$value];
    }
}