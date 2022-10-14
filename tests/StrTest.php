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
use Tobento\Service\Tag\Str;
use Stringable;

/**
 * StrTest
 */
class StrTest extends TestCase
{
    public function testEscMethod()
    {
        $string = Str::esc(
            string: '<p>lorem</p>', // string|Stringable
            flags: ENT_QUOTES, // default
            encoding: 'UTF-8', // default
            double_encode: true // default
        );
        
        $this->assertSame('&lt;p&gt;lorem&lt;/p&gt;', $string);
    }
    
    public function testEscMethodWithStringable()
    {
        $class = new class() implements Stringable {
            public function __toString(): string
            {
                return '<p>lorem</p>';
            }
        };
        
        $string = Str::esc(
            string: $class,
        );
        
        $this->assertSame('&lt;p&gt;lorem&lt;/p&gt;', $string);
    }
    
    public function testFormatTagAttributesMethod()
    {
        $string = Str::formatTagAttributes(
            attributes: [
                'class' => 'bar',
                'data-colors' => ['red' => 'Red'],
            ],
        );
        
        $this->assertSame(
            ' class="bar" data-colors=\'{&quot;red&quot;:&quot;Red&quot;}\'',
            $string
        );
    }
    
    public function testFormatTagAttributesMethodRendersEmptyAttributes()
    {
        $this->assertSame(
            ' data-foo=""',
            Str::formatTagAttributes([
                'data-foo' => '',
            ])
        );
    }
    
    public function testFormatTagAttributesMethodRemovesClassesWithSameNameIfArray()
    {
        $this->assertSame(
            ' class="bar foo"',
            Str::formatTagAttributes([
                'class' => ['bar', 'bar', 'foo'],
            ])
        );
    }
    
    public function testFormatTagAttributesMethodWithNullValueDoesRenderAttributeNameOnly()
    {
        $this->assertSame(
            ' required',
            Str::formatTagAttributes([
                'required' => null,
            ])
        );
    }
    
    public function testFormatTagAttributesMethodWithIntKeyDoesRenderAttributeNameOnly()
    {
        $this->assertSame(
            ' required',
            Str::formatTagAttributes([
                1 => 'required',
            ])
        );
    }
    
    public function testFormatTagAttributesMethodWithArrayListShouldConvertToJson()
    {
        $this->assertSame(
            ' data-foo=\'[&quot;bar&quot;,&quot;foo&quot;]\'',
            Str::formatTagAttributes([
                'data-foo' => ['bar', 'foo'],
            ])
        );
    }
    
    public function testFormatTagAttributesMethodWithAttrArrayShouldConvertToJson()
    {
        $this->assertSame(
            ' data-foo=\'{&quot;key&quot;:&quot;value&quot;}\'',
            Str::formatTagAttributes([
                'data-foo' => ['key' => 'value'],
            ])
        );
    }
    
    public function testFormatTagAttributesMethodWithoutSpace()
    {
        $this->assertSame(
            'class="foo"',
            Str::formatTagAttributes([
                'class' => 'foo',
            ], withSpace: false)
        );
    }
}