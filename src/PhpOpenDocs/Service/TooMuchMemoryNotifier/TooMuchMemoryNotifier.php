<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Service\TooMuchMemoryNotifier;

use Psr\Http\Message\ServerRequestInterface as Request;

interface TooMuchMemoryNotifier
{
    public function tooMuchMemory(Request $request);
}
