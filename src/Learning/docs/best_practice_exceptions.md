
# Recommended practices for exceptions 

The recommendations below are patterns of how to use exceptions in ways that will be appreciated by whoever has to maintain your application.  

## Set previous when catching and re-throwing

A mistake people make when first using exception is to not pass the previous  

```php
 try {
    foo();
 }
 catch (\TypeError $te) {
    throw new FooException("Something went wrong calling foo");
 } 
```

Because the original exception is not set as the previous exception, all information about the stack trace inside the foo function call is lost.


```php
 try {
    foo();
 }
 catch (\TypeError $te) {
    throw new FooException(
        "Something went wrong calling foo",
        $te->getCode(),
        $te
    );
 } 
```





If you don't do this, you will lose information about the exact cause of the exception.


## Common base exception per library

Creating a base exception for your library, and then extending all other exceptions from it allows consumers of your library to catch just a single exception type, rather than having to list all of the individual exceptions to be caught.

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
    throw new InvalidValueException(
      "Value foo is too big, max is " . MAX_FOO . " but got " . $foo
    );
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

TL:DR version, don't use exceptions for flow control. Except when you really want to.

### What is using exception for flow control

```php
class User {

    array $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getValue(string $key)
    {
        if (array_key_exists($name, $this->data) !== true) {
            throw new KeyNotAvailableException(
                "Key $key is not set"
            );
        }
    }
}

function sayHello(User $user) {
    try {
        $name = $user->getValue('name');
    }
    catch (KeyNotAvailableException $knae) {
        $name = 'friend'
    }
    
    return sprintf("Hello %s", $name)
}
```

This code can be modified to check if the value is going to be available first:

```php
class User {

    array $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function hasValue(string $key)
    {
        return array_key_exists($name, $this->data);
    }

    public function getValue(string $key)
    {
        if (array_key_exists($name, $this->data) !== true) {
            throw new KeyNotAvailableException(
                "Key $key is not set"
            );
        }
    }
}

function sayHello(User $user)
{
    $name = 'friend'

    if ($user->hasValue('name') === true) {
        $name = $user->getValue('name');
    }

    return sprintf("Hello %s", $name)
}
```

This avoids an exception being part of the normal code flow.


### Why shouldn't you use exceptions for flow control

There isn't an absolutely concrete reason to not use exceptions for flow control other than "a lot of people don't like code that does that".

Although that is a statement of personal preference, when a significant number of people, including (probably) most senior developers, have the same opinion about a coding pattern, it is probably good advice to follow that advice.  


### Are there any exceptions to this rule?

Yes.

Developing software costs money, and sometimes doing everything the 'right' way costs more than taking a shortcut.

When you have a deep chain of functions, and you know that none of the functions in the middle are going to be able to handle an exception, it can save a significant amount of complexity, and time, to take the short cut of using an exception for flow control.






## Further reading



[Exception-Handling Antipatterns](/java_exception_antipatterns) by Tim McCune.

There is however one piece of what I consider to be inappropriate advice in that article:

> Always try to group together all log messages, regardless of the level, into 
> as few calls as possible. So in the example above, the correct code would look like:
> `LOG.debug("Using cache policy A, using retry policy B");`

You can never know ahead of time what log lines need to be grouped together, and even when you can, cramming everything onto a single line might be hard to read.

Whatever logging tool you use, should include either the process or thread I.D. in the logging message, so that you can filter by that I.D. when viewing logs. 

Doing that solves the problem of being able to interpret the log lines, without having to put all related log details into a single log message.








