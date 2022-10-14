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
 * Str
 */
class Str
{
    /**
     * Escapes string with htmlspecialchars.
     * 
     * @param string|Stringable $string
     * @param int $flags
     * @param string $encoding
     * @param bool $double_encode
     * @return string
     */
    public static function esc(
        string|Stringable $string,
        int $flags = ENT_QUOTES,
        string $encoding = 'UTF-8',
        bool $double_encode = true
    ): string {
        
        if ($string instanceof Stringable) {
            $string = $string->__toString();
        }
        
        return htmlspecialchars($string, $flags, $encoding, $double_encode);
    }
    
    /**
     * Formats tag attributes.
     * 
     * @param array $attributes The attributes.
     * @param bool $withSpace
     * @return string The formatted attributes.
     */
    public static function formatTagAttributes(array $attributes, bool $withSpace = true): string
    {
        if (empty($attributes)) {
            return '';
        }

        $formatted = [];

        foreach($attributes as $name => $value) {
            
            if (is_int($name)) {
                $formatted[] = static::esc($value);
                continue;
            }
            
            if (is_null($value)) {
                $formatted[] = static::esc($name);
                continue;
            }
            
            if (is_array($value)) {
                
                if ($name === 'class') {
                    $formatted[] = static::esc($name).'="'.static::esc(implode(' ', array_unique($value))).'"';
                } else {
                    $formatted[] = static::esc($name)."='".static::esc(json_encode($value))."'";
                }
                
            } else {
                $formatted[] = static::esc($name).'="'.static::esc($value).'"';
            }
        }
        
        if ($withSpace) {
            return ' '.implode(' ', $formatted);
        }
        
        return implode(' ', $formatted);
    }
}