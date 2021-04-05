<?php

declare(strict_types=1);


//File perf_callable.php

//valgrind --tool=callgrind php perf_callable.php


class foo
{
    public function bar()
    {
    }
}

function passIt(callable $callable, $count)
{
    if ($count > 0) {
        passIt($callable, $count - 1);
    } else {
        $callable();
    }
}

function getCallable($foo): callable
{
    return [$foo, 'bar'];
}

$foo = new Foo();

for ($x = 0; $x < 10000; $x++) {
    $callable = getCallable($foo);
    passIt($callable, 8);
}

echo "OK";