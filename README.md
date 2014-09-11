# Mr. Clean

[![Latest Version](https://img.shields.io/github/release/joetannenbaum/mr-clean.svg?style=flat)](https://github.com/joetannenbaum/mr-clean/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/joetannenbaum/mr-clean/master.svg?style=flat)](https://travis-ci.org/joetannenbaum/mr-clean)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/joetannenbaum/mr-clean.svg?style=flat)](https://scrutinizer-ci.com/g/joetannenbaum/mr-clean/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/joetannenbaum/mr-clean.svg?style=flat)](https://scrutinizer-ci.com/g/joetannenbaum/mr-clean)
[![Total Downloads](https://img.shields.io/packagist/dt/joetannenbaum/mr-clean.svg?style=flat)](https://packagist.org/packages/joetannenbaum/mr-clean)

## Table of Contents

+ [Installation](#installation)

<!--
## Installation

Using [composer](https://packagist.org/packages/joetannenbaum/mr-clean):

```
{
    "require": {
        "joetannenbaum/mr-clean": "~0.0"
    }
}
```
-->

## Basic Usage

Fire it up like so:

```php
require_once 'vendor/autoload.php';

$cleaner = new MrClean\MrClean();
```

## Scrubbers

Scrubbers are the things that actually do the work. They can be either classes or functions, and you can assign as many as you want to clean your object.

```php
$scrubbed = $cleaner->cleaners([
                                'trim',
                                'stripslashes',
                                'strip_tags',
                                'remove_weird_characters',
                            ])
                    ->scrub('I\'m not that dirty.');
```

Scrubbers should always be passed as an array, and will be run in the order that you specify, the resulting object will be returned.

Any single argument string manipulation function can be used. To reference a class, simply convert the StudlyCase to snake_case. In the example above, `remove_weird_characters` refers to a class named `RemoveWeirdCharacters`.

## What Can Be Cleaned

Better question: what can't? An array of arrays, a string, an array of objects, a single object, you try it, Mr. Clean will probably be able to clean it. All of the following will work:

```php
$scrubbed = $cleaner->cleaners(['trim'])->scrub('Holy string, Batman.');

$scrubbed = $cleaner->cleaners(['trim'])->scrub(['Holy', 'array', 'Batman']);

$scrubbed = $cleaner->cleaners(['trim'])->scrub([
        ['Holy', 'array', 'of', 'arrays', 'Batman'],
        ['Holy', 'array', 'of', 'arrays', 'Batman'],
    ]);

$scrubbed = $cleaner->cleaners(['trim'])->scrub((object) [
        'first_word'  => 'Holy',
        'second_word' => 'object',
        'third_word'  => 'Batman',
    ]);

$scrubbed = $cleaner->cleaners(['trim'])->scrub([
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

$scrubbed = $cleaner->cleaners(['trim'])->scrub([
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

$scrubbed = $cleaner->cleaners($scrubbers)->scrub($data);

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

$scrubbed = $cleaner->cleaners(['boolean'])->scrub( $movies_seen );

/*
[
    'The Dark Knight'   => true,
    'The Green Lantern' => false,
    'The Avengers'      => true,
];
*/
```
