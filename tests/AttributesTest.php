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
use Tobento\Service\Tag\Attributes;

/**
 * AttributesTest
 */
class AttributesTest extends TestCase
{
    public function testEmptyMethod()
    {
        $this->assertTrue((new Attributes())->empty());
        
        $this->assertFalse((new Attributes())->set('data-foo', '1')->empty());
        
        $this->assertFalse((new Attributes(['data-foo' => '1']))->empty());
    }
    
    public function testHasMethod()
    {
        $this->assertFalse((new Attributes())->has('data-foo'));
        
        $this->assertTrue((new Attributes())->set('data-foo', '1')->has('data-foo'));
        
        $this->assertTrue((new Attributes(['data-foo' => '1']))->has('data-foo'));
        
        $this->assertTrue((new Attributes(['data-foo' => null]))->has('data-foo'));
    }
    
    public function testGetMethod()
    {
        $a = new Attributes(['data-foo' => '1']);
        
        $this->assertSame('1', $a->get('data-foo'));
        
        $this->assertSame(null, $a->get('data-bar'));
    }
    
    public function testSetMethod()
    {
        $a = new Attributes();
        
        $a->set('data-foo', '1');
            
        $this->assertSame('1', $a->get('data-foo'));
        
        $a->set('data-foo', '2');
        
        $this->assertSame('2', $a->get('data-foo'));
    }
    
    public function testSetMethodOverwritesExistingAttribute()
    {
        $a = new Attributes();
        
        $a->set(name: 'class', value: 'foo');

        $a->set('class', 'bar');
        
        $this->assertSame(' class="bar"', (string)$a);
    }    
    
    public function testAddMethod()
    {
        $a = new Attributes();
        
        $a->add('class', 'bar');
        
        $this->assertSame('bar', $a->get('class'));
        
        $a = new Attributes();
        
        $a->add('class', 'bar');
        $a->add('class', 'foo');
        
        $this->assertSame(['bar', 'foo'], $a->get('class'));
    }
    
    public function testMergeMethod()
    {
        $a = new Attributes();
        
        $a->merge(['class' => 'bar']);
        $a->merge(['class' => ['foo']]);
        
        $this->assertSame(['bar', 'foo'], $a->get('class'));
    }
    
    public function testAllMethod()
    {
        $a = new Attributes();
        
        $a->merge(['class' => 'bar']);
        $a->set('data-foo', '2');
        
        $this->assertSame(
            [
                'class' => 'bar',
                'data-foo' => '2',
            ],
            $a->all()
        );
    }
    
    public function testRenderMethod()
    {
        $a = new Attributes();
        
        $a->set('data-foo', '2');
        
        $this->assertSame(
            ' data-foo="2"',
            $a->render()
        );
    }
    
    public function testRenderMethodWithoutAttributes()
    {
        $a = new Attributes();
        
        $this->assertSame(
            '',
            $a->render()
        );
    }    
    
    public function testRenderMethodWithClass()
    {
        $a = new Attributes();
        
        $a->set('class', 'bar');
        $a->add('class', 'foo');
        
        $this->assertSame(
            ' class="bar foo"',
            $a->render()
        );
    }
    
    public function testRenderMethodWithNullValue()
    {
        $a = new Attributes();
        
        $a->set('async');
        $a->set('readonly', null);
        
        $this->assertSame(' async readonly', $a->render());
    }
    
    public function testRenderMethodWithEmptyStringValue()
    {
        $a = new Attributes();
        
        $a->set('data-foo', '');
        
        $this->assertSame(
            ' data-foo=""',
            $a->render()
        );
    }    
    
    public function testRenderMethodWithMulipleAttr()
    {
        $a = new Attributes();
        
        $a->set('class', 'bar');
        $a->add('class', 'foo');
        $a->set('data-foo', '2');
        
        $this->assertSame(
            ' class="bar foo" data-foo="2"',
            $a->render()
        );
    }
    
    public function testRenderMethodWithMulipleAttrOfSameKindShouldConvertToJson()
    {
        $a = new Attributes();
        
        $a->add('data-foo', 'bar');
        $a->add('data-foo', 'foo');
        
        $this->assertSame(
            ' data-foo=\'[&quot;bar&quot;,&quot;foo&quot;]\'',
            $a->render()
        );
    }
    
    public function testRenderMethodWithAttrArrayValueShouldConvertToJson()
    {
        $a = new Attributes();
        
        $a->set('data-foo', ['bar' => 'bar']);
        
        $this->assertSame(
            ' data-foo=\'{&quot;bar&quot;:&quot;bar&quot;}\'',
            $a->render()
        );
    }
    
    public function testRenderMethodWithDefaultAttributes()
    {
        $a = new Attributes([
            'class' => 'name',
            'data-foo' => '',

            // set null as value or an int key
            // as only to render the name:
            'required' => null,
            1 => 'readonly',

            // turns into json string:
            'data-bar' => ['key' => 'value'],
        ]);
        
        $this->assertSame(
            ' class="name" data-foo="" required readonly data-bar=\'{&quot;key&quot;:&quot;value&quot;}\'',
            $a->render()
        );
    }
    
    public function testRenderWithoutSpaceMethod()
    {
        $a = new Attributes([
            'class' => 'name',
        ]);
        
        $this->assertSame(
            'class="name"',
            $a->renderWithoutSpace()
        );
    }
}