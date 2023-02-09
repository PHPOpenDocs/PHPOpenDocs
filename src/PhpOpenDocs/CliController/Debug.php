<?php

declare(strict_types = 1);

namespace PHPOpenDocs\CliController;

use SlimAuryn\Response\HtmlResponse;

class Debug
{
    public function hello(): void
    {
        echo "Hello world.";
    }
}
