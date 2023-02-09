<?php

declare(strict_types = 1);

namespace PHPOpenDocs\AppController;

use PHPOpenDocs\Exception\DebuggingUncaughtException;
use PHPOpenDocs\Exception\DebuggingCaughtException;

class Debug
{
    public function testUncaughtException(): never
    {
        throw new DebuggingUncaughtException(
            "Hello, I am a test exception that won't be caught by the application."
        );
    }

    public function testCaughtException(): never
    {
        throw new DebuggingCaughtException(
            "Hello, I am a test exception that will be caught by the application."
        );
    }
}
