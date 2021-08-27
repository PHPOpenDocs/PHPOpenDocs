<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use function Internals\createPageFn;

$fn = createPageFn(
    __DIR__ . "/../../../vendor/danack/rfc-codex/etiquette/rfc_etiquette.md",
    'RFC etiquette',
    '/rfc_etiquette'
);

showInternalsResponse($fn);