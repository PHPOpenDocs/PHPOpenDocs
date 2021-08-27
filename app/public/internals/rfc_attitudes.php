<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use function Internals\createPageFn;

$fn = createPageFn(
    __DIR__ . "/../../../vendor/danack/rfc-codex/etiquette/rfc_attitudes.md",
    'RFC attitudes',
    '/rfc_attitudes'
);

showInternalsResponse($fn);