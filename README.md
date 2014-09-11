# Mr. Clean

[![Latest Version](https://img.shields.io/github/release/joetannenbaum/mr-clean.svg?style=flat)](https://github.com/joetannenbaum/mr-clean/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/joetannenbaum/mr-clean/master.svg?style=flat)](https://travis-ci.org/joetannenbaum/mr-clean)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/joetannenbaum/mr-clean.svg?style=flat)](https://scrutinizer-ci.com/g/joetannenbaum/mr-clean/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/joetannenbaum/mr-clean.svg?style=flat)](https://scrutinizer-ci.com/g/joetannenbaum/mr-clean)
[![Total Downloads](https://img.shields.io/packagist/dt/joetannenbaum/mr-clean.svg?style=flat)](https://packagist.org/packages/joetannenbaum/mr-clean)

## Table of Contents

+ [Installation](#installation)
+ [Basic Usage](#basic-usage)
+ [Scrubbers](#scrubbers)
+ [Pre/Post](#pre-post)
+ [What Can Be Cleaned](#what-can-be-cleaned)
+ [Cleaning Specific Keys](#cleaning-specific-keys)
+ [Available Scrubbers](#available-scrubbers)
    + [Boolean](#boolean)
    + [Nullify](#nullify)
    + [Null If Repeated](#null-if-repeated)
    + [Strip Phone Number](#strip-phone-number)
+ [Extending](#extending)
    + [Writing a Scrubber](#writing-a-scrubber)
    + [Registering a Scrubber](#registering-a-scrubber)

## Installation

Using [composer](https://packagist.org/packages/joetannenbaum/mr-clean):

```
{
    "require": {
        "joetannenbaum/mr-clean": "~0.0"
    }
}
```

## Basic Usage

Fire it up like so:

```php
require_once 'vendor/autoload.php';

$cleaner = new MrClean\MrClean();
```

## Scrubbers

Scrubbers are the classes and functions that actually do the work, and you can assign as many as you want to clean your object.

```php
$scrubbers = [
    'trim',
    'stripslashes',
    'strip_tags',
    'remove_weird_characters',
];

$scrubbed = $cleaner->scrubbers($scrubbers)->scrub('I\'m not that dirty.');
```

Scrubbers should always be passed as an array, and will be run in the order that you specify.

Any single argument string manipulation function can be used. To reference a class, simply convert the StudlyCase to snake_case. In the example above, `remove_weird_characters` refers to a (fictional) class named `RemoveWeirdCharacters`.

## Pre/Post

To save some typing, you can set scrubbers to run every time before and after each cleaning:

```php
$cleaner->pre(['trim']);
$cleaner->post(['htmlentities']);

// trim will run before each of these, htmlentities after each
$cleaner->scrubbers(['strip_tags'])->scrub('This should be cleaned.')
$cleaner->scrubbers(['remove_weird_characters'])->scrub('So should this.')
```

## What Can Be Cleaned

Better question: what can't? An array of arrays, a string, an array of objects, a single object, you try it, Mr. Clean will probably be able to clean it. All of the following will work:

```php
$scrubbed = $cleaner->scrubbers(['trim'])->scrub('Holy string, Batman.');

$scrubbed = $cleaner->scrubbers(['trim'])->scrub(['Holy', 'array', 'Batman']);

$scrubbed = $cleaner->scrubbers(['trim'])->scrub([
        ['Holy', 'array', 'of', 'arrays', 'Batman'],
        ['Holy', 'array', 'of', 'arrays', 'Batman'],
    ]);

$scrubbed = $cleaner->scrubbers(['trim'])->scrub((object) [
        'first_word'  => 'Holy',
        'second_word' => 'object',
        'third_word'  => 'Batman',
    ]);

$scrubbed = $cleaner->scrubbers(['trim'])->scrub([
        (object) [
            'first_word'  => 'Holy',
            'second_word' => 'array',
            'third_word'  => 'of',
            'fourth_word' => 'objects',
            'fifth_word'  => 'Batman',
        ],
        (object) [
            'first_word'  => 'Holy',
            'second_word' => 'array',
            'third_word'  => 'of',
            'fourth_word' => 'objects',
            'fifth_word'  => 'Batman',
        ],
    ]);

$scrubbed = $cleaner->scrubbers(['trim'])->scrub([
        (object) [
            'first_word'  => 'Holy',
            'second_word' => 'mixed',
            'third_word'  => ['bag', 'Batman'],
        ],
    ]);
```

## Cleaning Specific Keys

Sometimes you don't want to use the same scrubbers on every key in an object or associative array. No problem. Just let Mr. Clean know which ones to apply where and he'll take care of it:

```php
$scrubbers = [
    'first_name' => ['trim'],
    'last_name'  => ['stripslashes', 'htmlentities'],
];

$data = [
    [
        'first_name' => 'Joe ',
        'last_name'  => 'O\'Donnell',
    ],
    [
        'first_name' => ' Harold',
        'last_name'  => 'Frank & Beans',
    ],
];

$scrubbed = $cleaner->scrubbers($scrubbers)->scrub($data);

/*
[
    [
        'first_name' => 'Joe',
        'last_name'  => "O'Donnell",
    ],
    [
        'first_name' => 'Harold',
        'last_name'  => 'Frank &amp; Beans',
    ],
]
*/
```

You can also still specify scrubbers that should run for everything:

```php
$scrubbers = [
    'strip_tags',
    'first_name' => ['trim'],
    'last_name'  => ['stripslashes', 'htmlentities'],
    'htmlspecialchars',
];
```

## Available Scrubbers

Mr. Clean comes with a bevy of pre-built scrubbers you can use:

### Boolean

Converts falsey text and anything considered `empty` to `false`, otherwise returns `true`. Falsey text includes (not case sensitive):

+ no
+ n
+ false

```php
$movies_seen = [
    'The Dark Knight'   => 'y',
    'The Green Lantern' => 'n',
    'The Avengers'      => 'yes',
];

$scrubbed = $cleaner->scrubbers(['boolean'])->scrub( $movies_seen );

/*
[
    'The Dark Knight'   => true,
    'The Green Lantern' => false,
    'The Avengers'      => true,
];
*/
```

### Nullify

If a trimmed string doesn't have any length, null it out:

```php
$dirty = [
    'cool',
    'also cool',
    ' ',
    '    ',
];

$scrubbed = $cleaner->scrubbers(['nullify'])->scrub($dirty);

/*
[
    'cool',
    'also cool',
    null,
    null,
];
*/
```

### Null If Repeated

If a string is just a repeated character ('1111111' or 'aaaaaaaaa') and has a length greater than two, null it out:

```php
$dirty = [
    '11111111',
    '22',
    'bbbbbbbb',
    '333334',
];

$scrubbed = $cleaner->scrubbers(['null_if_repeated'])->scrub($dirty);

/*
[
    null,
    '22',
    null,
    '333334',
];
*/
```

### Strip Phone Number

Strip a phone number down to just the good bits, numbers and the letter 'x' (for extensions):

```php
$dirty = [
    '555-555-5555',
    '(123) 456-7890',
    '198 765 4321 ext. 888',
];

$scrubbed = $cleaner->scrubbers(['strip_phone_number'])->scrub($dirty);

/*
[
    '5555555555',
    '1234567890',
    '1987654321x888',
];
*/
```

## Extending

You can register custom scrubbers with Mr. Clean.

### Writing a Scrubber

First, write your class. All you have to do is extend `MrClean\Scrubber\BaseScrubber` which adheres to `MrClean\Scrubber\ScrubberInterface`. There is a single property, `value` available to you. This is the string you will manipulate:

```php
namespace Your\Namespace;

use MrClean\Scrubber\BaseScrubber;

class YourCustomScrubber extends BaseScrubber {

    public function scrub()
    {
        return str_replace('!', '.', $this->value);
    }

}
```

And that's it. Now just register your scrubber with Mr. Clean.

### Registering a Scrubber

The `register` method will take a string indicating the full path of the class, or an array of class paths.

```php
$cleaner->register('Your\Namespace\YourCustomScrubber');
```

Now, go ahead and use it:

```php
$dirty = [
    'I need to calm down!',
    'Me too!',
];

$scrubbed = $cleaner->scrubbers(['your_custom_scrubber'])->scrub($dirty);

/*
[
    'I need to calm down.',
    'Me too.',
]
*/
```
