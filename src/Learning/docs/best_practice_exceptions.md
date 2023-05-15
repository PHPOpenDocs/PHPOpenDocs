
# Recommended practices for exceptions 

The recommendations below are patterns of how to use exceptions in ways that will be appreciated by whoever has to maintain your application.  

<!-- Menu(h2, h3) -->

## Always set previous when catching and re-throwing

A mistake people make when first using exception is to not pass the previous exception when catching and throwing a more specific exeption.

```php
 try {
    foo();
 }
 catch (\TypeError $te) {
    throw new FooException("Something went wrong calling foo");
 } 
```

Because the original exception is not set as the previous exception, all information about the stack trace inside the foo function call is lost.

Simply by setting the previous exception when throwing the new exception all the information is retained.

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

This can be enforced with a [PHPStan strict rule](https://github.com/thecodingmachine/phpstan-strict-rules/blob/master/src/Rules/Exceptions/ThrowMustBundlePreviousExceptionRule.php) or a [TheCodeMachine strict rules](https://github.com/thecodingmachine/phpstan-strict-rules) altenative. Or both.



## Single catchable exception type per library/module

For anyone calling your code, it is useful to be able to catch any exception your code might throw with a single catch statement:

```
try {
   foo();
}
catch (FooException $fe) {
   // something went wrong with foo, and
   // we don't particularly care what.
}
```

rather than having to catch every possible exception:

```
try {
   foo();
}
catch (InvalidArgumentException|OutOfRangeException $fe) {
   // something went wrong with foo, and
   // we don't particularly care what.
}
```

Not only is having a single exception type to catch easier to write, it also means that if you add another exception to your library/module then people using your library will catch that new exception by default, rather than having to alter their code to catch the new exception.

This can be accomplished in at least two ways.

### Common base exception

Creating a base exception for your library, and then extending all other exceptions from it allows consumers of your library to catch just a single exception type, rather than having to list all of the individual exceptions to be caught.

[Base exception](https://github.com/Danack/Params/blob/7c2ffd076ba8ba924df617ccd92fd62e4a28099f/lib/Params/Exception/ParamsException.php#L10), [example extended exception](https://github.com/Danack/Params/blob/7c2ffd076ba8ba924df617ccd92fd62e4a28099f/lib/Params/Exception/LogicException.php#L11)


### Common interface

Interfaces in PHP are allowed to be empty, so you can define a 'FooException' interface that has no methods:

```
interface FooException {}
```

These are often called 'marker' or 'tag' interfaces. You can then 'implement' that interface on all of the exceptions that are defined by the library/module 'Foo':

```
class InvalidArgumentException implements FooException { ... }

class OutOfRangeException implements FooException { ... }
```




## Catch exceptions from code you are calling and rethrow more specific

Imagine we have an interface in our code that performs some operation that returns a particular type:

```php
interface Foo
{
    public function bar(): Quux;
}
```

And we have a simple implementation that uses Redis as the storage:

```php
class RedisFoo implements Foo
{
    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }
    
    public function bar(): Quux
    {
        $data = $this->redis->get('quux');
        if ($data === false) {
            return Quux::createNew();
        }
        
        return Quux::createFromString($data);
    }   
}
```
This code works and looks fine, but contains a nasty aspect that is revealed when someone uses it: 


```php
function process(Foo $foo)
{
    try {
        $foo->bar();
    }
    catch (RedisException $re) {
        // do something appropriate here.
    }    
}
```

As the calling code has to catch a RedisException this is an 'implementation leak'. If the underlying implementation is switched to use MemCache instead of Redis, then the calling code would also need to be updated to catch the appropriate MemCache exception:

```php
function process(Foo $foo)
{
    try {
        $foo->bar();
    }
    catch (RedisException|MemCacheException $re) {
        // do something appropriate here.
    }    
}
```

Having to change the calling code, when an internal implementation detail is changed is bad.

We can fix this by catching the RedisException inside the implementation code and then throwing an exception specific to our library:

```php
class RedisFoo implements Foo
{
    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }
    
    public function bar(): Quux
    {
        try {
            $data = $this->redis->get('quux');
            if ($data === false) {
                return Quux::createNew();
            }
            
            return Quux::createFromString($data);
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

Now the calling code never needs to change which exception it catches.

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

By adding a static named constructor, the details of the message can be inside the exception:

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

Not only does that standardise the message in the exception, it also means the programmer doesn't need to think about what to write in the message. And the less thinking required, the better.


## Define exception messages as class constants

Most developers start by writing exception messages inline in the place where they are used:

```php
define("MAX_FOO", 100);

function bar(int $foo)
{
    if ($foo > MAX_FOO) { 
        throw new InvalidValueException(
          "Value for foo is too big, max is " . MAX_FOO . " but got " . $foo
        );
        // ...
    }
}

class BarTest extends TestCase
{
    public function testFooTooLarge()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessageRegExp("#Value for foo is too big, max is .* but got .*#");
        bar(4000);
    }
} 
```

This is bad for a couple of reasons:

* It's duplication of the message text, which means that the test is fragile. When someone changes the text used in the exception, the test will start failing and the test will need to be updated.
* It requires effort. Copying the message text and formatting it for regexp takes a non-trivial amount of time.

Rather than defining exception messages inline, it's better to move them to be class constants:

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

function bar(int $foo)
{
    if ($foo > MAX_FOO) { 
        throw InvalidValueException::tooBig(MAX_FOO, 100)
    }
    // ...
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

The test can reference the exception message from the class constant. 

Now if the text for the exception message is ever updated, the test will use the updated version without the test having to be updated separately.

The function `templateStringToRegExp` is available from the library [danack/php-unit-helper](https://packagist.org/packages/danack/php-unit-helper), or you could just copy/paste it if you don't want an extra dependency.


## Don't use deep exception hierarchies

More words here...


## Don't use exceptions for flow control

TL:DR version, don't use exceptions for flow control. Except when you really want to.

### What is 'using exceptions for flow control' ?

Imagine we have some code that allows us to retrieve values and we use it to 'say hello' to a user:

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

In that code, if the name of the user is not available, an exception is thrown and caught almost immediately. i.e. the flow of which operations are called is controlled by an exception.

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


### Why do people think using exceptions for flow control is wrong?

There isn't a single absolutely concrete reason to not use exceptions for flow control other than "a lot of people don't like code that does that".

Although that is a statement of personal preference, when a significant number of people, including (probably) most senior developers, have the same opinion about a coding pattern, it is probably a good idea to follow that advice.  

### Are there any exceptions to this rule?

Yes.

Developing software costs money, and sometimes doing everything the 'right' way costs more than taking a shortcut.

When you have a deep chain of functions, and you know that none of the functions in the middle are going to be able to handle an exception, it can save a significant amount of complexity, and time, to take the shortcut of using an exception for flow control.

There's at least one reasonable example [of using an exception for flow control](https://blog.jooq.org/2013/04/28/rare-uses-of-a-controlflowexception/). Although it would be possible to rewrite the code discussed in that link to not use an exception, that would also involve making the code more complex, and having to write significantly more tests, than using an exception as a global 'goto'. 

## Further reading

[Exception-Handling Antipatterns](/learning/java_exception_antipatterns) by Tim McCune.

There is however one piece of what I consider to be inappropriate advice in that article:

> Always try to group together all log messages, regardless of the level, into 
> as few calls as possible. So in the example above, the correct code would look like:
> `LOG.debug("Using cache policy A, using retry policy B");`

You can never know ahead of time what log lines need to be grouped together, and even when you can, cramming everything onto a single line might be hard to read.

Whatever logging tool you use, should include either the process or thread I.D. in the logging message, so that you can filter by that I.D. when viewing logs. 

Doing that solves the problem of being able to interpret the log lines, without having to put all related log details into a single log message.









