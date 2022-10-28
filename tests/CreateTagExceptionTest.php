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

namespace Tobento\Service\Tag\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Tag\CreateTagException;

/**
 * CreateTagExceptionTest
 */
class CreateTagExceptionTest extends TestCase
{
    public function testGetMessageReturnsDefaultMessageIfNoCustomMessage()
    {
        $this->assertSame(
            'Could not create tag',
            (new CreateTagException())->getMessage()
        );
    }
    
    public function testGetMessageReturnsDefaultMessageIfNoCustomMessageWithTagName()
    {
        $this->assertSame(
            'Could not create tag [svg]',
            (new CreateTagException('svg'))->getMessage()
        );
    }
    
    public function testGetMessageReturnsCustomMessage()
    {
        $this->assertSame(
            'Custom',
            (new CreateTagException(message: 'Custom'))->getMessage()
        );
    }
    
    public function testGetNameMessage()
    {
        $this->assertSame(
            'li',
            (new CreateTagException('li'))->name()
        );
        
        $this->assertSame(
            null,
            (new CreateTagException())->name()
        );        
    }
    
    public function testGetHtmlMessage()
    {
        $this->assertSame(
            '<p></p>',
            (new CreateTagException(html: '<p></p>'))->html()
        );
        
        $this->assertSame(
            null,
            (new CreateTagException())->html()
        );        
    }
}