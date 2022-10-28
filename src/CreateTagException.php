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
use Exception;
use Throwable;

/**
 * CreateTagException
 */
class CreateTagException extends Exception
{
    /**
     * Create a new CreateTagException.
     *
     * @param null|string $name
     * @param null|string|Stringable $html
     * @param string $message The message
     * @param int $code
     * @param null|Throwable $previous
     */
    public function __construct(
        protected null|string $name = null,
        protected null|string|Stringable $html = null,
        string $message = '',
        int $code = 0,
        null|Throwable $previous = null
    ) {
        if ($message === '') {
            $name = is_null($name) ? '' : ' ['.$name.']';
            $message = sprintf('Could not create tag%s', $name);
        }
        
        parent::__construct($message, $code, $previous);
    }

    /**
     * Returns the tag name.
     *
     * @return null|string
     */
    public function name(): null|string
    {
        return $this->name;
    }
    
    /**
     * Returns the tag html.
     *
     * @return null|string|Stringable
     */
    public function html(): null|string|Stringable
    {
        return $this->html;
    }
}