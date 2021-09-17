<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\CopyrightInfo;
use function Internals\createRemoteMarkdownPageFn;

$fn = createRemoteMarkdownPageFn(
    "https://raw.githubusercontent.com/php/php-src/master/CONTRIBUTING.md",
    'Contributing to PHP',
    '/php_contributing',
    new CopyrightInfo("The PHP Group", "https://github.com/php/php-src/blob/master/LICENSE")
);

showInternalsResponse($fn);