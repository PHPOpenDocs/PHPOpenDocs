<?php

declare(strict_types = 1);

namespace PHPOpenDocs\Service\TooMuchMemoryNotifier;

use Psr\Http\Message\ServerRequestInterface as Request;

interface TooMuchMemoryNotifier
{
    public function tooMuchMemory(Request $request): void;
}
