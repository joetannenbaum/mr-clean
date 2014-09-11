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
require 'vendor/autoload.php';

$cleaner = new MrClean\MrClean();
```

## Scrubbers

Scrubbers are the classes that actually do the work, and Mr. Clean comes with a bevy of pre-built scrubbers you can use:

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
$movies_seen = [
    'The Dark Knight'   => true,
    'The Green Lantern' => false,
    'The Avengers'      => true,
];
*/
```
