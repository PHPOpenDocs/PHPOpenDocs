
# Recommended practices for exceptions 




## Common base exception per library

Creating a base exception for your library, and then extending all other exceptions from it allows consumers of your library

[Base exception](https://github.com/Danack/Params/blob/7c2ffd076ba8ba924df617ccd92fd62e4a28099f/lib/Params/Exception/ParamsException.php#L10), [example extended exception](https://github.com/Danack/Params/blob/7c2ffd076ba8ba924df617ccd92fd62e4a28099f/lib/Params/Exception/LogicException.php#L11)



 

## Use static factory methods

This allows you to avoid repeating strings in code, or even worse, have slightly different messages for the same exception.

## Use class constant for messages

This allows you to test messages are correct.


## Set previous when catching and re-throwing

## Catch generic exceptions rethrow more specific

```php

function foo(string $bar)
{
    try {
        quux($bar);
    }
    catch (\RedisException $e) {
        throw FooException::fromPrevious(
            'Calling quux failed',
            $bar,
            $e
        );
    }
}
```


## Don't use exceptions for flow control


## Further reading

[Exception-Handling Antipatterns](https://web.archive.org/web/20110304010308/https://today.java.net/article/2006/04/04/exception-handling-antipatterns) by Tim McCune.

There is however one piece of what I consider to be inappropriate advice in that article:

> Always try to group together all log messages, regardless of the level, into 
> as few calls as possible. So in the example above, the correct code would look like:
> `LOG.debug("Using cache policy A, using retry policy B");`
>

You can never know ahead of time what log lines need to be grouped together, and even when you can, cramming everything onto a single line might be hard to read.

Whatever logging tool you use, should include either the process or thread I.D. in the logging message, so that you can filter by that I.D. when viewing logs. 

Doing that solves the problem of 









