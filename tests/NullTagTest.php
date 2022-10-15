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
use Tobento\Service\Tag\TagInterface;
use Tobento\Service\Tag\NullTag;
use Tobento\Service\Tag\Attributes;

/**
 * NullTagTest
 */
class NullTagTest extends TestCase
{
    public function testThatImplementsTagInterface()
    {
        $this->assertInstanceOf(
            TagInterface::class,
            new NullTag('html')
        );
    }
    
    public function testTagGetters()
    {
        $tag = new NullTag(
            html: 'html',
            level: 2,
        );
        
        $this->assertSame('', $tag->getName());
        $this->assertSame('html', $tag->getHtml());
        $this->assertInstanceof(Attributes::class, $tag->attributes());
        $this->assertSame(2, $tag->getLevel());
    }
    
    public function testWithNameMethod()
    {
        $tag = new NullTag();
        $tagNew = $tag->withName('ul');
        
        $this->assertFalse($tag === $tagNew);
        $this->assertSame('', $tagNew->getName());
    }

    public function testWithHtmlMethod()
    {
        $tag = new NullTag();
        $tagNew = $tag->withHtml('html');
        
        $this->assertFalse($tag === $tagNew);
        $this->assertSame('html', $tagNew->getHtml());
    }
    
    public function testWithLevelMethod()
    {
        $tag = new NullTag();
        $tagNew = $tag->withLevel(2);
        
        $this->assertFalse($tag === $tagNew);
        $this->assertSame(2, $tagNew->getLevel());
    }
    
    public function testWithAttributesMethod()
    {
        $tag = new NullTag();
        $attributes = new Attributes();
        $tagNew = $tag->withAttributes($attributes);
        
        $this->assertFalse($tag === $tagNew);
        $this->assertTrue($attributes === $tagNew->attributes());
        $this->assertFalse($attributes === $tag->attributes());
    }
    
    public function testPrependMethod()
    {
        $tag = new NullTag(html: 'html');
        
        $this->assertSame(
            'foohtml',
            $tag->prepend('foo')->getHtml()
        );
        
        $this->assertSame(
            'foobarhtml',
            $tag->prepend('bar')->getHtml()
        );
        
        $this->assertSame(
            'foobarhtml',
            (string)$tag
        );
    }
    
    public function testAppendMethod()
    {
        $tag = new NullTag(html: 'html');
        
        $this->assertSame(
            'htmlfoo',
            $tag->append('foo')->getHtml()
        );
        
        $this->assertSame(
            'htmlfoobar',
            $tag->append('bar')->getHtml()
        );
        
        $this->assertSame(
            'htmlfoobar',
            (string)$tag
        );
    }
    
    public function testRenderMethod()
    {
        $tag = new NullTag(html: 'html');
            
        $this->assertSame(
            'html',
            $tag->render()
        );
        
        $this->assertSame(
            'html',
            (string)$tag
        );        
    }
    
    public function testOpenMethod()
    {
        $tag = new NullTag(html: 'html');
        
        $this->assertSame('', $tag->open());
    }
    
    public function testCloseMethod()
    {
        $tag = new NullTag(html: 'html');
        
        $this->assertSame('', $tag->close());    
    }
}