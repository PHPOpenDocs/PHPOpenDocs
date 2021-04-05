<?php

declare(strict_types=1);

function foo()
{
    posix_kill(posix_getpid(), 11);
}


foo();


//valgrind --tool=callgrind ./sapi/cli/php perf_callable.php