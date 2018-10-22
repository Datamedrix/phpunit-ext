# PHPUnit Extension Library

A collection of constraints, asserts and test-cases for the PHPUnit framework.

> For more information please visit [https://phpunit.de](https://phpunit.de)

## Requirements

* PHP >= 7.2
* Composer >= 1.5
* phpunit >= 7.0

## Installation

Use composer to install and use this package in your project.

Install them with

```bash
composer require "dmx/phpunit-ext"
```

and you are ready to go!

## Usage

The most convenient way to use the additional constraints and assets is to inherit
your test case class from `DMX\PHPUnit\Framework\TestCase`.

Now you can use the following constraints and assets in your tests.

### Assertions

#### assertIsClosure

`assertIsClosure(mixed $actual [, string $message = '']): void`

Reports an error identified by **$message** if **$actual** is not an instance of **\Closure**.

*Example* 
```php
$actual = function () {
    return 'Foo.Bar';
}

$this->assertIsClosure($actual);
```

#### assertClosure

`assertClosure(mixed $expectedReturnValue, mixed $actual [, string $message = '']): void`

Reports an error identified by **$message** if **$actual** is not an instance of **\Closure** or
the return value of the designated closure does not match with **$expectedReturnValue**.

*Example*
```php
$actual = function () {
    return 'Foo.Bar';
}
$expectedReturnValue = 'Foo.Bar';

$this->assertClosure($expectedReturnValue, $actual);
```

#### assertCarbon

`assertCarbon(mixed $expectedDateTime, mixed $actual [, int $epsilon = 0, string $message = '']): void`

Reports an error identified by **$message** if **$actual** does not match with the **$expectedCarbon**. 
If an **$epsilon** is set, the **$actual** value could diverse the amount of seconds defined by the epsilon.

*Example*
```php
$expected = '2018-10-22 14:00:00';
$actual = '2018-10-22 14:00:05';

$this->assertCarbon($expected, $actual, 10);
```

## Development - Getting Started

See the [CONTRIBUTING](CONTRIBUTING.md) file.

## Changelog

See the [CHANGELOG](CHANGELOG.md) file.
