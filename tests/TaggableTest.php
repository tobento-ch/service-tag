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
use Tobento\Service\Tag\Taggable;
use Tobento\Service\Tag\HasTag;
use Tobento\Service\Tag\Tag;

/**
 * TaggableTest
 */
class TaggableTest extends TestCase
{
    public function testTaggable()
    {
        $taggable = new class() implements Taggable {
            use HasTag;
        };
        
        $tag = new Tag(name: 'p');
        
        $taggable->setTag($tag);
        
        $this->assertSame($tag, $taggable->tag());
    }
}