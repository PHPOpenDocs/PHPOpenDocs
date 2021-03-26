

# Exception-Handling Antipatterns

Tim McCune April 6, 2006

## Contents

*   [Basic Exception Concepts](#basic-exception-concepts)
*   [Creating Your Own Exceptions](#creating-your-own-exceptions)
*   [Exceptions and Transactions](#exceptions-and-transactions)
    *   [EJB 2](#ejb2)
    *   [EJB 3](#ejb3)
    *   [Message-Driven Beans](#message-driven-beans)
*   [Logging](#logging)
*   [Antipatterns](#antipatterns)
    *   [Log and Throw](#logAndThrow)
    *   [Throwing Exception](#throwingException)
    *   [Throwing the Kitchen Sink](#throwingTheKitchenSink)
    *   [Catching Exception](#catchingException)
    *   [Destructive Wrapping](#destructiveWrapping)
    *   [Log and Return Null](#logAndReturnNull)
    *   [Catch and Ignore](#catchAndIgnore)
    *   [Throw from Within Finally](#throwFromWithinFinally)
    *   [Multi-Line Log Messages](#multilineLogMessages)
    *   [Unsupported Operation Returning Null](#unsupportedOperationReturningNull)
    *   [Ignoring `InterruptedException`](#ignoringInterruptedException)
    *   [Relying on `getCause()`](#relyingOnGetCause)
*   [Conclusion](#conclusion)
*   [Resources](#resources)

Should you throw an exception, or return `null`? Should you use checked or unchecked exceptions? For many novice to mid-level developers, exception handling tends to be an afterthought. Their typical pattern is usually a simple `try`/`catch`/`printStackTrace()`. When they try to get more creative, they usually stumble into one or more common exception handling antipatterns.

The antipattern concept became popular in the software development community with the release of [AntiPatterns: Refactoring Software, Architectures, and Projects in Crisis](https://web.archive.org/web/20110304010308/http://www.amazon.com/exec/obidos/ASIN/0471197130/) in 1998. An antipattern draws on real-world experience to identify a commonly occurring programming mistake. It describes the general form of the bad pattern, identifies its negative consequences, prescribes a remedy, and helps define a common vocabulary by giving each pattern a name.

In this article, we'll discuss some fundamental concepts about the different types of Java exceptions and their intended uses. We'll also cover basic logging concepts, especially as they relate to exception handling. Finally, instead of prescribing what to do, we'll focus on what not to do, and take a look at a dozen common exception-handling antipatterns that you are almost certain to find somewhere in your code base.

## Basic Exception Concepts

One of the most important concepts about exception handling to understand is that there are three general types of throwable classes in Java: checked exceptions, unchecked exceptions, and errors.

Checked exceptions are exceptions that must be declared in the `throws` clause of a method. They extend `Exception` and are intended to be an "in your face" type of exceptions. A checked exception indicates an expected problem that can occur during normal system operation. Some examples are problems communicating with external systems, and problems with user input. Note that, depending on your code's intended function, "user input" may refer to a user interface, or it may refer to the parameters that another developer passes to your API. Often, the correct response to a checked exception is to try again later, or to prompt the user to modify his input.

Unchecked exceptions are exceptions that do not need to be declared in a `throws` clause. They extend `RuntimeException`. An unchecked exception indicates an unexpected problem that is probably due to a bug in the code. The most common example is a `NullPointerException`. There are many core exceptions in the JDK that are checked exceptions but really shouldn't be, such as `IllegalAccessException` and `NoSuchMethodException`. An unchecked exception probably shouldn't be retried, and the correct response is usually to do nothing, and let it bubble up out of your method and through the execution stack. This is why it doesn't need to be declared in a `throws` clause. Eventually, at a high level of execution, the exception should probably be logged (see [below](#antipatterns)).

Errors are serious problems that are almost certainly not recoverable. Some examples are `OutOfMemoryError`, `LinkageError`, and `StackOverflowError`.

## Creating Your Own Exceptions

Most packages and/or system components should contain one or more custom exception classes. There are two primary use cases for a custom exception. First, your code can simply throw the custom exception when something goes wrong. For example:

```
throw new MyObjectNotFoundException("Couldn't find
    object id " + id);
```

Second, your code can wrap and throw another exception. For example:

```
catch (NoSuchMethodException e) {
  throw new MyServiceException("Couldn't process
      request", e);
}
```

Wrapping an exception can provide extra information to the user by adding your own message (as in the example above), while still preserving the stack trace and message of the original exception. It also allows you to hide the implementation details of your code, which is the most important reason to wrap exceptions. For instance, look at the [Hibernate API](https://web.archive.org/web/20110304010308/http://www.hibernate.org/hib_docs/v3/api/). Even though Hibernate makes extensive use of JDBC in its implementation, and most of the operations that it performs can throw `SQLException`, Hibernate does not expose `SQLException` anywhere in its API. Instead, it wraps these exceptions inside of various subclasses of `HibernateException`. Using the approach allows you to change the underlying implementation of your module without modifying its public API.

## Exceptions and Transactions

### EJB 2

The creators of the [EJB 2 specification](https://web.archive.org/web/20110304010308/http://java.sun.com/products/ejb/docs.html) decided to make use of the distinction between checked and unchecked exceptions to determine whether or not to roll back the active transaction. If an EJB throws a checked exception, the transaction still commits normally. If an EJB throws an unchecked exception, the transaction is rolled back. You almost always want an exception to roll back the active transaction. It just helps to be aware of this fact when working with EJBs.

### EJB 3

To somewhat alleviate the problem that I just described, EJB 3 has added an [`ApplicationException`](https://web.archive.org/web/20110304010308/https://glassfish.dev.java.net/nonav/javaee5/api/s1as-javadocs/javax/ejb/ApplicationException.html) annotation with a `rollback` element. This gives you explicit control over whether or not your exception (either checked or unchecked) should roll back the transaction. For example:

```
@ApplicationException(rollback=true)
public class FooException extends Exception
...
```

### Message-Driven Beans

Be aware that when working with message-driven beans (MDBs) that are driven by a queue, rolling back the active transaction also places the message that you are currently processing back on the queue. The message will then be redelivered to another MDB, possibly on another machine, if your app servers are clustered. It will be retried until it hits the app server's retry limit, at which point the message is left on the dead letter queue. If your MDB wants to avoid reprocessing (e.g., because it performs an expensive operation), it can call `getJMSRedelivered()` on the message, and if it was redelivered, it can just throw it away.

## Logging

When your code encounters an exception, it must either handle it, let it bubble up, wrap it, or log it. If your code can programmatically handle an exception (e.g., retry in the case of a network failure), then it should. If it can't, it should generally either let it bubble up (for unchecked exceptions) or wrap it (for checked exceptions). However, it is ultimately going to be someone's responsibility to log the fact that this exception occurred if nobody in the calling stack was able to handle it programmatically. This code should typically live as high in the execution stack as it can. Some examples are the `onMessage()` method of an MDB, and the `main()` method of a class. Once you catch the exception, you should log it appropriately.

The JDK has a [`java.util.logging`](https://web.archive.org/web/20110304010308/http://java.sun.com/j2se/1.5.0/docs/api/java/util/logging/package-frame.html) package built in, although the [Log4j](https://web.archive.org/web/20110304010308/http://logging.apache.org/log4j/docs/) project from Apache continues to be a commonly-used alternative. Apache also offers the [Commons Logging](https://web.archive.org/web/20110304010308/http://jakarta.apache.org/commons/logging/) project, which acts as a thin layer that allows you to swap out different logging implementations underneath in a pluggable fashion. All of these logging frameworks that I've mentioned have basically equivalent levels:

*   `FATAL`: Should be used in extreme cases, where immediate attention is needed. This level can be useful to trigger a support engineer's pager.
*   `ERROR`: Indicates a bug, or a general error condition, but not necessarily one that brings the system to a halt. This level can be useful to trigger email to an alerts list, where it can be filed as a bug by a support engineer.
*   `WARN`: Not necessarily a bug, but something someone will probably want to know about. If someone is reading a log file, they will typically want to see any warnings that arise.
*   `INFO`: Used for basic, high-level diagnostic information. Most often good to stick immediately before and after relatively long-running sections of code to answer the question "What is the app doing?" Messages at this level should avoid being very chatty.
*   `DEBUG`: Used for low-level debugging assistance.

If you are using commons-logging or Log4j, watch out for a common gotcha. The `error`, `warn`, `info`, and `debug` methods are overloaded with one version that takes only a message parameter, and one that also takes a `Throwable` as the second parameter. Make sure that if you are trying to log the fact that an exception was thrown, you pass both a message and the exception. If you call the version that accepts a single parameter, and pass it the exception, it hides the stack trace of the exception.

When calling `log.debug()`, it's good practice to always surround the call with a check for `log.isDebugEnabled()`. This is purely for optimization. It's simply a good habit to get into, and once you do it for a few days, it will just become automatic.

Do not use `System.out` or `System.err`. You should always use a logger. Loggers are extremely configurable and flexible, and each appender can decide which level of severity it wants to report/act on, on a package-by-package basis. Printing a message to `System.out` is just sloppy and generally unforgivable.

## Antipatterns

### Log and Throw

Example:

```
catch (NoSuchMethodException e) {
  LOG.error("Blah", e);
  throw e;
}
```

or

```
catch (NoSuchMethodException e) {
  LOG.error("Blah", e);
  throw new MyServiceException("Blah", e);
}
```

or

```
catch (NoSuchMethodException e) {
  e.printStackTrace();
  throw new MyServiceException("Blah", e);
}
```

All of the above examples are equally wrong. This is one of the most annoying error-handling antipatterns. Either log the exception, or throw it, but never do both. Logging and throwing results in multiple log messages for a single problem in the code, and makes life hell for the support engineer who is trying to dig through the logs.

### Throwing Exception

Example:

```
public void foo() throws Exception {
```

This is just sloppy, and it completely defeats the purpose of using a checked exception. It tells your callers "something can go wrong in my method." Real useful. Don't do this. Declare the specific checked exceptions that your method can throw. If there are several, you should probably wrap them in your own exception (see "[Throwing the Kitchen Sink](#throwingTheKitchenSink)" below.)

### Throwing the Kitchen Sink

Example:

```
public void foo() throws MyException,
    AnotherException, SomeOtherException,
    YetAnotherException
{
```

Throwing multiple checked exceptions from your method is fine, as long as there are different possible courses of action that the caller may want to take, depending on which exception was thrown. If you have multiple checked exceptions that basically mean the same thing to the caller, wrap them in a single checked exception.

### Catching Exception

Example:

```
try {
  foo();
} catch (Exception e) {
  LOG.error("Foo failed", e);
}
```

This is generally wrong and sloppy. Catch the specific exceptions that can be thrown. The problem with catching `Exception` is that if the method you are calling later adds a new checked exception to its method signature, the developer's intent is that you should handle the specific new exception. If your code just catches `Exception` (or worse, `Throwable`), you'll probably never know about the change and the fact that your code is now wrong.

### Destructive Wrapping

Example:

```
catch (NoSuchMethodException e) {
  throw new MyServiceException("Blah: " +
      e.getMessage());
}
```

This destroys the stack trace of the original exception, and is always wrong.

### Log and Return Null

Example:

```
catch (NoSuchMethodException e) {
  LOG.error("Blah", e);
  return null;
}
```

or

```
catch (NoSuchMethodException e) {
  e.printStackTrace();
  return null;
}  // Man I hate this one
```

Although not always incorrect, this is usually wrong. Instead of returning `null`, throw the exception, and let the caller deal with it. You should only return `null` in a normal (non-exceptional) use case (e.g., "This method returns null if the search string was not found.").

### Catch and Ignore

Example:

```
catch (NoSuchMethodException e) {
  return null;
}
```

This one is insidious. Not only does it return `null` instead of handling or re-throwing the exception, it totally swallows the exception, losing the information forever.

### Throw from Within Finally

Example:

```
try {
  blah();
} finally {
  cleanUp();
}
```

This is fine, as long as `cleanUp()` can never throw an exception. In the above example, if `blah()` throws an exception, and then in the `finally` block, `cleanUp()` throws an exception, that second exception will be thrown and the first exception will be lost forever. If the code that you call in a `finally` block can possibly throw an exception, make sure that you either handle it, or log it. Never let it bubble out of the `finally` block.

### Multi-Line Log Messages

Example:

```
LOG.debug("Using cache policy A");
LOG.debug("Using retry policy B");
```

Always try to group together all log messages, regardless of the level, into as few calls as possible. So in the example above, the correct code would look like:

```
LOG.debug("Using cache policy A, using retry policy B");
```

Using a multi-line log message with multiple calls to `log.debug()` may look fine in your test case, but when it shows up in the log file of an app server with 500 threads running in parallel, all spewing information to the same log file, your two log messages may end up spaced out 1000 lines apart in the log file, even though they occur on subsequent lines in your code.

### Unsupported Operation Returning Null

Example:

```
public String foo() {
  // Not supported in this implementation.
  return null;
}
```

When you're implementing an abstract base class, and you're just providing hooks for subclasses to optionally override, this is fine. However, if this is not the case, you should throw an [`UnsupportedOperationException`](http://java.sun.com/j2se/1.5.0/docs/api/java/lang/UnsupportedOperationException.html) instead of returning `null`. This makes it much more obvious to the caller why things aren't working, instead of her having to figure out why her code is throwing some random `NullPointerException`.

### Ignoring `InterruptedException`

Example:

```
while (true) {
  try {
    Thread.sleep(100000);
  } catch (InterruptedException e) {}
  doSomethingCool();
}
```

`InterruptedException` is a clue to your code that it should stop whatever it's doing. Some common use cases for a thread getting interrupted are the active transaction timing out, or a thread pool getting shut down. Instead of ignoring the `InterruptedException`, your code should do its best to finish up what it's doing, and finish the current thread of execution. So to correct the example above:

```
while (true) {
  try {
    Thread.sleep(100000);
  } catch (InterruptedException e) {
    break;
  }
  doSomethingCool();
}
```

### Relying on `getCause()`

Example:

```
catch (MyException e) {
  if (e.getCause() instanceof FooException) {
    ...
```

The problem with relying on the result of `getCause` is that it makes your code fragile. It may work fine today, but what happens when the code that you're calling into, or the code that it relies on, changes its underlying implementation, and ends up wrapping the ultimate cause inside of another exception? Now calling `getCause` may return you a wrapping exception, and what you really want is the result of `getCause().getCause()`. Instead, you should unwrap the causes until you find the ultimate cause of the problem. Apache's [commons-lang](https://web.archive.org/web/20110304010308/http://jakarta.apache.org/commons/lang/) project provides [`ExceptionUtils.getRootCause()`](https://web.archive.org/web/20110304010308/http://jakarta.apache.org/commons/lang/api/org/apache/commons/lang/exception/ExceptionUtils.html#getRootCause(java.lang.Throwable)) to do this easily.

## Conclusion

Good exception handling is a key to building robust, reliable systems. Avoiding the antipatterns that we've outlined here helps you build systems that are maintainable, resilient to change, and that play well with other systems.

## Resources

*   "[Best Practices for Exception Handling](https://web.archive.org/web/20110304010308/http://www.onjava.com/pub/a/onjava/2003/11/19/exceptions.html)"
*   "[Three Rules for Effective Exception Handling](https://web.archive.org/web/20110304010308/http://today.java.net/pub/a/today/2003/12/04/exceptions.html)"
*   "[Handling Errors Using Exceptions](http://java.sun.com/docs/books/tutorial/essential/exceptions/index.html)" from the Java tutorial
*   [Antipattern](https://web.archive.org/web/20110304010308/http://en.wikipedia.org/wiki/Antipattern) entry on Wikipedia
*   [Log4j](https://web.archive.org/web/20110304010308/http://logging.apache.org/log4j/docs/)
*   [Commons Logging](https://web.archive.org/web/20110304010308/http://jakarta.apache.org/commons/logging/)
*   [EJB specifications](https://web.archive.org/web/20110304010308/http://java.sun.com/products/ejb/docs.html)


-----

Originally published at https://today.java.net/article/2006/04/04/exception-handling-antipatterns

Republished here with kind permission from Tim McCune.