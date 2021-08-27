<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use function Learning\createPageFn;

$fn = createPageFn(
    __DIR__ . "/../../../src/Learning/docs/best_practice_shorts.md",
    'Best practice shorts',
    '/best_practice_shorts'
);

showInternalsResponse($fn);