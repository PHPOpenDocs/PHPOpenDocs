<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\CopyrightInfo;
use function Internals\createRemoteMarkdownPageFn;
use PhpOpenDocs\Types\RemoteMarkdownPage;

$fn = createRemoteMarkdownPageFn(
    new RemoteMarkdownPage("https://raw.githubusercontent.com/php/php-src/master/docs/parameter-parsing-api.md"),
    'PHP parameter parsing',
    new CopyrightInfo("The PHP Group.", "https://github.com/php/php-src/blob/master/LICENSE")
);

showPageResponse($fn);