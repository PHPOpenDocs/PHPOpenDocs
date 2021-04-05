<?php

declare(strict_types=1);

//File perf_closure.php

//valgrind --tool=callgrind php perf_closure.php


class foo
{
    public function bar()
    {
    }
}

function passIt(Closure $callable, $count)
{
    if ($count > 0) {
        passIt($callable, $count - 1);
    } else {
        $callable();
    }
}

function getCallable($foo): Closure
{
    return Closure::fromCallable([$foo, 'bar']);
}

$foo = new Foo();

for ($x = 0; $x < 10000; $x++) {
    $callable = getCallable($foo);
    passIt($callable, 8);
}

echo "OK";