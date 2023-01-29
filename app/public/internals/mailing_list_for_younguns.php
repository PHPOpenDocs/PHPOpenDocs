<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use function Internals\createPageFn;

$fn = createPageFn(
    __DIR__ . "/../../../vendor/danack/rfc-codex/etiquette/mailing_list_for_younguns.md",
    'Mailing list etiquette',
    '/mailing_list'
);

showInternalsResponse($fn);