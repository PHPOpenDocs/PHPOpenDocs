
# Recommended practices for exceptions 

Exceptions 

The recommendations below are simple suggestions on how to  

## Set previous when catching and re-throwing




## Common base exception per library

Creating a base exception for your library, and then extending all other exceptions from it allows consumers of your library to c

[Base exception](https://github.com/Danack/Params/blob/7c2ffd076ba8ba924df617ccd92fd62e4a28099f/lib/Params/Exception/ParamsException.php#L10), [example extended exception](https://github.com/Danack/Params/blob/7c2ffd076ba8ba924df617ccd92fd62e4a28099f/lib/Params/Exception/LogicException.php#L11)


## Catch exceptions from code you are calling and rethrow more specific

```php

class RedisFoo implements Foo
{
    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }
    
    public function bar()
    {
        try {
            // Any 
            $this->redis->set('quux', 5);
        }
        catch (\RedisException $e) {
            throw FooException::fromPrevious(
                'Setting quux failed',
                $bar,
                $e
            );
        }
    }   
}
```

 

## Use static/named constructor methods

This allows you to avoid repeating strings in code, or even worse, have slightly different messages for the same exception.

Imagine you have this exception:

```php
class InvalidValueException extends \Exception {
}
```

One programmer might use it like this:

```php
if ($foo > MAX_FOO) { 
    throw new InvalidValueException("Value foo is too big, max is " . MAX_FOO . " but got " . $foo);
}
```

Another programmer might use it like this:
```php
if ($foo > MAX_FOO) { 
    throw new InvalidValueException("Value $foo is too big, max allowed " . MAX_FOO);
}
```

By adding a static named constructor, the details of the message can be inside the exception 

```php

class InvalidValueException extends \Exception
{
    public static tooBig(int $max, int $actual)
    {
        $message = sprintf(
            "Value %s is too big, max allowed is %s",
            $actual,
            $max
        );
        return new InvalidValueException($message);
    }
}

```

Now whenever a programmer wants to throw that exception, they can use the named constructor.

```php
if ($foo > MAX_FOO) {
    throw InvalidValueException::tooBig(MAX_FOO, $foo);
}
```

Not only does that standardise the message in the exception, is also means the programmer doesn't need to think about what to write in the message. And the less thinking required, the better.


## Use class constant for messages

This allows you to test messages are correct.


```php

class BarTest extends TestCase
{
    public function testFooTooLarge()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessageRegExp("#Value .* is too big, max allowed is .*#");
        bar(4000);
    }
} 
```

This is bad for a couple of reasons:

* It's duplication of the message text. Which means that the test is fragile as if the text ever changes, the test will start failing.
* It requires effort. Copying the message text and formatting it for regexp takes a non-trivial amount of time.


```php

class InvalidValueException extends \Exception
{
    const VALUE_TOO_BIG_MESSAGE = "Value %s is too big, max allowed is %s";

    public static function tooBig(int $max, int $actual)
    {
        $message = sprintf(
            self::VALUE_TOO_BIG_MESSAGE,
            $actual,
            $max
        );
        return new InvalidValueException($message);
    }
}


class BarTest extends TestCase
{
    public function testFooTooLarge()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectErrorMessageMatches(
            templateStringToRegExp(InvalidValueException::VALUE_TOO_BIG_MESSAGE)
        );
        bar(4000);
    }
} 

```

The function `templateStringToRegExp` is available from the library [danack/php-unit-helper](https://packagist.org/packages/danack/php-unit-helper), or you could just copy/paste it if you don't want an extra dependency.



## Don't use exceptions for flow control

TODO - words....

## Further reading

[Exception-Handling Antipatterns](https://web.archive.org/web/20110304010308/https://today.java.net/article/2006/04/04/exception-handling-antipatterns) by Tim McCune.

There is however one piece of what I consider to be inappropriate advice in that article:

> Always try to group together all log messages, regardless of the level, into 
> as few calls as possible. So in the example above, the correct code would look like:
> `LOG.debug("Using cache policy A, using retry policy B");`
>

You can never know ahead of time what log lines need to be grouped together, and even when you can, cramming everything onto a single line might be hard to read.

Whatever logging tool you use, should include either the process or thread I.D. in the logging message, so that you can filter by that I.D. when viewing logs. 

Doing that solves the problem of being able to interpret the log lines, without having to put all related log details into a single log message.









