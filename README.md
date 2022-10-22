# Tag Service

HTML tags for PHP applications.

## Table of Contents

- [Getting started](#getting-started)
    - [Requirements](#requirements)
    - [Highlights](#highlights)
- [Documentation](#documentation)
    - [Tag](#tag)
        - [Create Tag](#create-tag)
        - [Tag Interface](#tag-interface)
    - [NullTag](#nulltag) 
    - [Taggable](#taggable)
    - [Attributes](#attributes)
        - [Create Attributes](#create-attributes)
        - [Attributes Interface](#attributes-interface)
    - [Str](#str)
- [Credits](#credits)
___

# Getting started

Add the latest version of the tag service project running this command.

```
composer require tobento/service-tag
```

## Requirements

- PHP 8.0 or greater

## Highlights

- Framework-agnostic, will work with any project
- Decoupled design

# Documentation

## Tag

### Create Tag

```php
use Tobento\Service\Tag\Tag;
use Tobento\Service\Tag\TagInterface;

$tag = new Tag(
    name: 'p',
    html: 'html' // Must be escaped
);

var_dump($tag instanceof TagInterface);
// bool(true)
```

You might adjust the default parameters.

```php
use Tobento\Service\Tag\Tag;
use Tobento\Service\Tag\Attributes;

$tag = new Tag(
    name: 'li',
    html: 'html', // Must be escaped
    attributes: new Attributes(), // is default
    level: 2, // default is null
    renderEmptyTag: false, // default is true
);
```

### Tag Interface

**getters**

```php
use Tobento\Service\Tag\Tag;
use Tobento\Service\Tag\TagInterface;
use Tobento\Service\Tag\AttributesInterface;

$tag = new Tag(name: 'li', html: 'html');

var_dump($tag instanceof TagInterface);
// bool(true)

var_dump($tag->getName());
// string(2) "li"

var_dump($tag->getHtml());
// string(4) "html"

var_dump($tag->getLevel());
// NULL (or int)

var_dump($tag->attributes() instanceof AttributesInterface);
// bool(true)
```

**with methods**

The with methods will return a new instance.

```php
use Tobento\Service\Tag\Tag;
use Tobento\Service\Tag\Attributes;

$tag = new Tag(name: 'li', html: 'html');

$tag = $tag->withName('ul');

$tag = $tag->withHtml('html');

$tag = $tag->withLevel(2);

$tag = $tag->withAttributes(new Attributes());

$tag = $tag->withAttr(name: 'data-foo', value: 'bar');
```

**manipulation methods**

```php
use Tobento\Service\Tag\Tag;

$tag = new Tag(name: 'li', html: 'html');

$tag->prepend(html: 'foo');

var_dump($tag->getHtml());
string(7) "foohtml"

$tag->append(html: 'bar');

var_dump($tag->getHtml());
// string(10) "foohtmlbar"
```

**attributes methods**

The attr method will overwrite attributes with same names.

```php
use Tobento\Service\Tag\Tag;

$tag = new Tag(name: 'li', html: 'html');

$tag->attr(name: 'data-foo', value: 'bar');
$tag->attr(name: 'data-foo', value: 'foo');

var_dump(htmlspecialchars((string)$tag));
// string(50) "<li data-foo="foo">html</li>"
```

```php
use Tobento\Service\Tag\Tag;

$tag = new Tag(name: 'li', html: 'html');

$tag->class(value: 'bar');
$tag->class(value: 'foo');

var_dump(htmlspecialchars((string)$tag));
// string(51) "<li class="bar foo">html</li>"
```

**render methods**

```php
use Tobento\Service\Tag\Tag;

$tag = new Tag(name: 'p', html: 'html');

<?= $tag->render() ?>

// or just
<?= $tag ?>
```

Sometimes, it might be useful not rendering the tag if it is empty. You may do so if you set render empty tag to false, it returns an empty string if there is no html.

```php
use Tobento\Service\Tag\Tag;

$tag = new Tag(
    name: 'p',
    html: '',
    renderEmptyTag: false
);

var_dump($tag->render());
// string(0) ""
```

You may want to do the opening and closing by yourself.

```php
use Tobento\Service\Tag\Tag;

$tag = new Tag(name: 'p', html: 'html');

var_dump(htmlspecialchars($tag->open()));
// string(9) "<p>"

if (!$tag->isSelfClosing()) {
    var_dump(htmlspecialchars($tag->close()));
    // string(10) "</p>"
}
```

## NullTag

The NullTag::class does not render any html tag at all only its html.

```php
use Tobento\Service\Tag\NullTag;
use Tobento\Service\Tag\TagInterface;

$tag = new NullTag(
    html: 'html', // Must be escaped
    level: 2, // default is null
);

var_dump($tag instanceof TagInterface);
// bool(true)

var_dump((string)$tag);
// string(4) "html"
```

## Taggable

```php
use Tobento\Service\Tag\Taggable;
use Tobento\Service\Tag\HasTag;
use Tobento\Service\Tag\Tag;
use Tobento\Service\Tag\TagInterface;

class Foo implements Taggable
{
    use HasTag;
}

$foo = new Foo();
$foo->setTag(new Tag(name: 'p'));

var_dump($foo->tag() instanceof TagInterface);
// bool(true)
```

## Attributes

### Create Attributes

```php
use Tobento\Service\Tag\Attributes;
use Tobento\Service\Tag\AttributesInterface;

$attributes = new Attributes();

var_dump($attributes instanceof AttributesInterface);
// bool(true)

// or
$attributes = new Attributes([
    'class' => 'name',
    'data-foo' => '',
    
    // set null as value or an int key
    // as only to render the name:
    'required' => null,
    1 => 'readonly',
    
    // turns into json string:
    'data-bar' => ['key' => 'value'],
]);

var_dump((string)$attributes);
// string(90) " class="name" data-foo="" required readonly data-bar='{"key":"value"}'"
```

### Attributes Interface

**empty**

```php
use Tobento\Service\Tag\Attributes;
use Tobento\Service\Tag\AttributesInterface;

$attributes = new Attributes();

var_dump($attributes instanceof AttributesInterface);
// bool(true)

var_dump($attributes->empty());
// bool(true)

$attributes = new Attributes(['class' => 'foo']);

var_dump($attributes->empty());
// bool(false)
```

**has**

```php
use Tobento\Service\Tag\Attributes;

$attributes = new Attributes(['class' => 'foo']);

var_dump($attributes->has('id'));
// bool(false)

var_dump($attributes->has('class'));
// bool(true)
```

**get**

```php
use Tobento\Service\Tag\Attributes;

$attributes = new Attributes([
    'class' => 'foo',
    'data-foo' => ['key' => 'value'],
]);

var_dump($attributes->get(name: 'id'));
// NULL

var_dump($attributes->get('class'));
// string(3) "foo"

var_dump($attributes->get('data-foo'));
// array(1) { ["key"]=> string(5) "value" }
```

**set**

The set method does overwrite existing attributes.

```php
use Tobento\Service\Tag\Attributes;

$attributes = new Attributes();

$attributes->set(name: 'class', value: 'foo');

$attributes->set('class', 'bar');

var_dump((string)$attributes);
// string(12) " class="bar""
```

You might just set the name only for certain attributes:

```php
use Tobento\Service\Tag\Attributes;

$attributes = new Attributes();

$attributes->set('readonly');

var_dump((string)$attributes);
// string(9) " readonly"
```

**add**

The add method does "merge" existing attributes.

```php
use Tobento\Service\Tag\Attributes;

$attributes = new Attributes();

$attributes->add(name: 'class', value: 'foo');

$attributes->add('class', 'bar');

var_dump((string)$attributes);
// string(16) " class="foo bar""

$attributes = new Attributes();

$attributes->add('data-cars', ['volvo' => 'Volvo']);
$attributes->add('data-cars', ['bmw' => 'BMW']);

var_dump((string)$attributes);
// string(82) " data-cars='{"volvo":"Volvo","bmw":"BMW"}'"
```

**merge**

The merge method merges the specified attributes with the existing attributes.

```php
use Tobento\Service\Tag\Attributes;

$attributes = new Attributes([
    'class' => 'foo',
    'data-colors' => ['blue' => 'Blue'],
]);

$attributes->merge(attributes: [
    'class' => 'bar',
    'data-colors' => ['red' => 'Red'],
]);

var_dump((string)$attributes);
// string(98) " class="foo bar" data-colors='{"blue":"Blue","red":"Red"}'"
```

**all**

Returns all attributes.

```php
use Tobento\Service\Tag\Attributes;

$attributes = new Attributes([
    'class' => 'foo',
]);

var_dump($attributes->all());
// array(1) { ["class"]=> string(3) "foo" }
```

**render**

```php
use Tobento\Service\Tag\Attributes;

$attributes = new Attributes([
    'class' => 'foo',
]);

var_dump($attributes->render());
// string(12) " class="foo""
```

If there are attributes, it returns an empty space at the beginning, otherwise an empy string.

This way you can simply do the following:

```php
<p<?= $attributes ?>>Lorem ipsum</p>
```

**renderWithoutSpace**

```php
use Tobento\Service\Tag\Attributes;

$attributes = new Attributes([
    'class' => 'foo',
]);

var_dump($attributes->renderWithoutSpace());
// string(11) "class="foo""
```

## Str

**esc**

Returns the escaped string.

```php
use Tobento\Service\Tag\Str;

$escapedString = Str::esc(
    string: 'string', // string|Stringable
    flags: ENT_QUOTES, // default
    encoding: 'UTF-8', // default
    double_encode: true // default
);

var_dump($escapedString);
// string(6) "string"
```

**formatTagAttributes**

Returns the formatted and escaped attributes as string.

```php
use Tobento\Service\Tag\Str;

$string = Str::formatTagAttributes(
    attributes: [
        'class' => 'bar',
        'data-colors' => ['red' => 'Red'],
    ],
    withSpace: true, // default
);

var_dump($string);
// string(60) " class="bar" data-colors='{"red":"Red"}'"
```

# Credits

- [Tobias Strub](https://www.tobento.ch)
- [All Contributors](../../contributors)