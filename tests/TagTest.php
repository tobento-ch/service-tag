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
use Tobento\Service\Tag\Tag;
use Tobento\Service\Tag\TagInterface;
use Tobento\Service\Tag\Attributes;

/**
 * TagTest
 */
class TagTest extends TestCase
{
    protected array $selfClosingTags = [
        'area', 'br', 'col', 'embed', 'hr', 'img', 'input',
        'link', 'meta', 'param', 'source', 'track', 'wbr',
    ];    

    public function testThatImplementsTagInterface()
    {
        $this->assertInstanceOf(
            TagInterface::class,
            new Tag('p')
        );
    }
    
    public function testTagGetters()
    {
        $tag = new Tag(
            name: 'li',
            html: 'html', // Must be escaped
            attributes: null,
            level: 2, // default is null
            renderEmptyTag: false, // default is true
        );
        
        $this->assertSame('li', $tag->getName());
        $this->assertSame('html', $tag->getHtml());
        $this->assertInstanceof(Attributes::class, $tag->attributes());
        $this->assertSame(2, $tag->getLevel());
    }
    
    public function testWithNameMethod()
    {
        $tag = new Tag(name: 'p');
        $tagNew = $tag->withName('ul');
        
        $this->assertFalse($tag === $tagNew);
        $this->assertSame('ul', $tagNew->getName());
    }

    public function testWithHtmlMethod()
    {
        $tag = new Tag(name: 'p');
        $tagNew = $tag->withHtml('html');
        
        $this->assertFalse($tag === $tagNew);
        $this->assertSame('html', $tagNew->getHtml());
    }
    
    public function testWithLevelMethod()
    {
        $tag = new Tag(name: 'p');
        $tagNew = $tag->withLevel(2);
        
        $this->assertFalse($tag === $tagNew);
        $this->assertSame(2, $tagNew->getLevel());
    }
    
    public function testWithAttributesMethod()
    {
        $tag = new Tag(name: 'p');
        $attributes = new Attributes();
        $tagNew = $tag->withAttributes($attributes);
        
        $this->assertFalse($tag === $tagNew);
        $this->assertTrue($attributes === $tagNew->attributes());
        $this->assertFalse($attributes === $tag->attributes());
    }
    
    public function testPrependMethod()
    {
        $tag = new Tag(name: 'p', html: 'html');
        
        $this->assertSame(
            'foohtml',
            $tag->prepend('foo')->getHtml()
        );
        
        $this->assertSame(
            'foobarhtml',
            $tag->prepend('bar')->getHtml()
        );
        
        $this->assertSame(
            '<p>foobarhtml</p>',
            (string)$tag
        );
    }
    
    public function testAppendMethod()
    {
        $tag = new Tag(name: 'p', html: 'html');
        
        $this->assertSame(
            'htmlfoo',
            $tag->append('foo')->getHtml()
        );
        
        $this->assertSame(
            'htmlfoobar',
            $tag->append('bar')->getHtml()
        );
        
        $this->assertSame(
            '<p>htmlfoobar</p>',
            (string)$tag
        );
    }
    
    public function testAttrMethod()
    {
        $tag = new Tag(name: 'p', html: 'html');
        
        $this->assertSame(
            '<p readonly data-foo="bar">html</p>',
            (string)$tag->attr(name: 'readonly')->attr(name: 'data-foo', value: 'bar')
        );
    }
    
    public function testClassMethod()
    {
        $tag = new Tag(name: 'p', html: 'html');
        
        $tag->class(value: 'bar');
        $tag->class(value: 'foo');
            
        $this->assertSame(
            '<p class="bar foo">html</p>',
            (string)$tag
        );
    }
    
    public function testRenderMethod()
    {
        $tag = new Tag(name: 'p', html: 'html');
        
        $tag->class(value: 'bar');
        $tag->attr(name: 'readonly');
            
        $this->assertSame(
            '<p class="bar" readonly>html</p>',
            $tag->render()
        );
        
        $this->assertSame(
            '<p class="bar" readonly>html</p>',
            (string)$tag
        );        
    }
    
    public function testRenderEmptyTagRendersEmptyStringIfEmptyHtml()
    {
        $tag = new Tag(name: 'p', html: '', renderEmptyTag: false);
            
        $this->assertSame('', $tag->render());
    }
    
    public function testRenderEmptyTagRendersTagIfNotEmptyHtml()
    {
        $tag = new Tag(name: 'p', html: 'html', renderEmptyTag: false);
            
        $this->assertSame('<p>html</p>', $tag->render());
    }
    
    public function testRenderEmptyTagRendersEmptyStringIfEmptyHtmlEvenIfHasAttributes()
    {
        $tag = new Tag(name: 'p', html: '', renderEmptyTag: false);
        
        $tag->class(value: 'bar');
        
        $this->assertSame('', $tag->render());
    }
    
    public function testSelfClosingTagDoesNotRenderClosingTag()
    {
        foreach($this->selfClosingTags as $name) {
            $tag = new Tag(name: $name, html: 'html');
            $this->assertSame('<'.$name.'>', $tag->render());
        }
    }
    
    public function testOpenMethod()
    {
        $tag = new Tag(name: 'p', html: 'html');
        
        $this->assertSame('<p>', $tag->open());
    }
    
    public function testOpenMethodWithAttributes()
    {
        $tag = new Tag(name: 'p', html: 'html');
        
        $tag->class(value: 'bar');
        
        $this->assertSame('<p class="bar">', $tag->open());
    }
    
    public function testCloseMethod()
    {
        $tag = new Tag(name: 'p');
        
        $this->assertSame('</p>', $tag->close());
        
        // should render closing tag
        $tag = new Tag(name: 'input');
        
        $this->assertSame('</input>', $tag->close());
    }
    
    public function testIsSelfClosingMethod()
    {        
        foreach($this->selfClosingTags as $name) {
            $tag = new Tag(name: $name);
            $this->assertTrue($tag->isSelfClosing());
        }
        
        $tag = new Tag(name: 'p');
        $this->assertFalse($tag->isSelfClosing());
    }
}