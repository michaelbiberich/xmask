# Xmask _(michaelbiberich/xmask)_

[![standard-readme compliant](https://img.shields.io/badge/readme%20style-standard-brightgreen.svg?style=flat-square)](https://github.com/RichardLitt/standard-readme)

> Convert string masks to regular expression patterns

## Table of Contents

- [Install](#install)
  - [Tests](#tests)
- [Usage](#usage)
- [Maintainers](#maintainers)
- [Contributing](#contributing)
- [License](#license)

## Install

Add **xmask** as a dependency to your project with [composer](https://getcomposer.org/).

```bash
$ composer require michaelbiberich/xmask ^1
```

### Tests

Tests can be run using [PHPUnit](https://phpunit.de/), see [phpunit.xml.dist](./phpunit.xml.dist).

```bash
$ phpunit --configuration ./phpunit.xml.dist
```

## Usage

```php
<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use MichaelBiberich\Xmask\Xmask;

$xmask = new Xmask('xxx456xxx', [
    'x' => '0-9',
]);

$pattern = $xmask->pattern();
// => string(67) "/^([0-9]{1})([0-9]{1})([0-9]{1})456([0-9]{1})([0-9]{1})([0-9]{1})$/"

preg_match($pattern, '123456789'); // => int(1)
preg_match($pattern, '123000789'); // => int(0)
preg_match($pattern, 'abc456789'); // => int(0)

// Examples: Value added tax identification numbers (VATINs)

$austriaVatinXmask = new Xmask('ATUxxxxxxxxx', [
    'x' => '0-9',
]);

$austriaVatinPattern = $austriaVatinXmask->pattern();

preg_match($austriaVatinPattern, 'ATU123456789'); // => int(1)
preg_match($austriaVatinPattern, 'ATU12345678'); // => int(0)

$cyprusVatinXmask = new Xmask('CYxxxxxxxxX', [
    'x' => '0-9',
    'X' => 'A-Z',
]);

$cyprusVatinPattern = $cyprusVatinXmask->pattern();
// => string(96) "/^CY([0-9]{1})([0-9]{1})([0-9]{1})([0-9]{1})([0-9]{1})([0-9]{1})([0-9]{1})([0-9]{1})([A-Z]{1})$/"

preg_match($cyprusVatinPattern, 'CY12345678A'); // => int(1)
preg_match($cyprusVatinPattern, 'CY123456789'); // => int(0)

```

## Maintainers

[@michaelbiberich](https://github.com/michaelbiberich).

## Contributing

Feel free to dive in! [Open an issue](https://github.com/michaelbiberich/xmask/issues/new) or submit PRs.

## License

[MIT](LICENSE.md) © Michael Biberich
