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
use Tobento\Service\Tag\TagFactory;
use Tobento\Service\Tag\TagFactoryInterface;
use Tobento\Service\Tag\TagInterface;
use Tobento\Service\Tag\NullTag;
use Tobento\Service\Tag\Attributes;

/**
 * TagFactoryTest
 */
class TagFactoryTest extends TestCase
{
    public function testThatImplementsTagFactoryInterface()
    {
        $this->assertInstanceOf(
            TagFactoryInterface::class,
            new TagFactory()
        );
    }
    
    public function testCreateTagMethod()
    {
        $tag = (new TagFactory())->createTag(name: 'p');
        
        $this->assertInstanceOf(
            TagInterface::class,
            $tag
        );
    }
    
    public function testCreateTagMethodWithAllParams()
    {
        $tag = (new TagFactory())->createTag(
            name: 'p',
            html: 'html',
            attributes: new Attributes(),
            level: 2,
        );
        
        $this->assertInstanceOf(
            TagInterface::class,
            $tag
        );
    }
    
    public function testCreateTagMethodWithEmptyNameReturnsNullTag()
    {
        $tag = (new TagFactory())->createTag(name: '');
        
        $this->assertInstanceOf(
            NullTag::class,
            $tag
        );
    }    
    
    public function testCreateTagFromHtmlMethod()
    {
        $tag = (new TagFactory())->createTagFromHtml(html: 'html');
        
        $this->assertInstanceOf(
            TagInterface::class,
            $tag
        );
    }
}