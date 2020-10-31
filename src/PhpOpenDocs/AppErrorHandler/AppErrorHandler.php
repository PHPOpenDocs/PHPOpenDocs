<?php

declare(strict_types = 1);

namespace PhpOpenDocs\AppErrorHandler;

/**
 * These are the Slim level error handlers.
 * Theoretically, none of these should ever be reached.
 *
 */
interface AppErrorHandler
{
    public function __invoke($container);
}
