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
 * AttributesInterface
 */
interface AttributesInterface extends Stringable
{
    /**
     * If attributes empty.
     *
     * @return bool
     */
    public function empty(): bool;

    /**
     * If an attribute exists.
     *
     * @param string $name The name.
     * @return bool True if exist, else false.
     */
    public function has(string $name): bool;

    /**
     * Get an attribute
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name): mixed;
    
    /**
     * Set an attribute.
     *
     * @param string $name
     * @param mixed $value
     * @return static $this
     */
    public function set(string $name, mixed $value = null): static;
    
    /**
     * Add an attribute.
     *
     * @param string $name
     * @param mixed $value
     * @return static $this
     */
    public function add(string $name, mixed $value = null): static;
    
    /**
     * Merge attributes.
     *
     * @param array $attributes The attributes to merge
     * @return static $this
     */
    public function merge(array $attributes): static;
    
    /**
     * Get all attributes.
     *
     * @return array
     */
    public function all(): array;
    
    /**
     * Returns the string representation of the attributes.
     * It must return an empty space at the beginning
     * if there are attributes, otherwise an empy string.
     *
     * @return string
     */
    public function render(): string;
    
    /**
     * Returns the evaluated contents of the attributes
     * without and empty space at the beginning.
     *
     * @return string
     */
    public function renderWithoutSpace(): string;
}