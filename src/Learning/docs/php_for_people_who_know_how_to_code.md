
# PHP for people who know how to program

So, you've chosen / been forced to learn PHP! Congratulations, it's actually not as bad you might have heard.

This guide is a brief introduction 

## Package managers

There are two main package managers in PHP, Composer and PECL.

[Composer](https://getcomposer.org/) is the package manager used to install userland libraries.

* Commit the composer.lock file to your VCS. 

* `composer install`


[PECL](https://pecl.php.net/) is the package manager used to install PHP extensions.

## Frameworks

### [Laminas](https://getlaminas.org/) 

Laminas is an 'enterprise-ready PHP Framework and components'. Laminas is a continuation of the Zend Framework.

### [Laravel](https://laravel.com/)

Laravel is an highly opinionated framework for making PHP web applications and set of components.

### [Slim](https://www.slimframework.com/) 

Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs. For reference, this site uses Slim.

### [Symfony](https://symfony.com/)

Symfony is an opinionated framework for making PHP web applications and set of components.

## High performance frameworks

As well as traditional 'shared nothing' frameworks, PHP also has some high performance frameworks. These are more difficult to write code for than traditional frameworks, that trade-off is sometimes the correct choice when you have high performance needs.

### [Amphp](https://amphp.org/)

Amp is an event-driven concurrency framework for PHP providing primitives to manage cooperative multitasking building upon an event loop, and promises.

### [ReactPHP](https://reactphp.org/)

ReactPHP is a low-level library for event-driven programming in PHP. At its core is an event loop, on top of which it provides low-level utilities, ... Third-party libraries can use these components to create async network clients/servers and more.

### [Swoole](https://www.swoole.co.uk/)

Build high-performance, scalable, concurrent TCP, UDP, Unix Socket, HTTP, WebSocket services with PHP and easy to use coroutine, fiber API.

## Code quality tools

### [PHPStan](https://phpstan.org/)

### [Psalm](https://psalm.dev/)

### [Phan](https://github.com/phan/phan)

### [Infection](https://infection.github.io/)






## Concepts

Although PHP is similar to other languages, there are a few concepts/names for things that people should be aware of, that might be difficult to search for.

### Autoloading

PHP is interpreted at runtime. PHP is not compiled like C, Java, Go programs and also isn't built/transpiled like TypeScript/Dart.

Because of this, when the code is run, PHP may need load another file that defines a class/interface if they are not already defined.

For the vast majority of PHP developers, autoloading is taken care by using Composer.


### Strict vs weak modes

PHP can operator in two modes 'strict' and 'weak'. In weak mode, if you pass a parameter to a function of a different type than expected, PHP will do it's best to coerce it into the correct type. For example PHP will coerce a float into an int by rounding it to the nearest int:

```php
<?php

function addNumbers(int $x, int $y): int {
    return $x + $y;
}

echo addNumbers(1, 2);
// output is 3

echo addNumbers(1, 2.4);
// output is also 3, as 2.4 was coerced to an int value of 2 
```

In strict mode, parameters need to be of the correct type, and passing an incorrect type will lead to a TypeError exception being thrown.

```php
<?php

declare(strict_types = 1);

function addNumbers(int $x, int $y): int {
    return $x + $y;
}

echo addNumbers(1, 2);
// output is 3

echo addNumbers(1, 2.4);

// Fatal error: Uncaught TypeError: addNumbers(): Argument
// #2 ($y) must be of type int, float given
```

In strict mode there is an exception for promoting ints to floats

```php
<?php

declare(strict_types = 1);

function foo(float $bar): float {
    return $bar;
}

$x = 1;
var_dump($x, foo($x));

// Output is:
// int(1)
// float(1)
```
By default (i.e. without any declare statement) PHP operates in weak mode.

### Core

TODO...

### Userland

TODO...

### Extensions

TODO...
