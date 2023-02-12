<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\CopyrightInfo;
use PHPOpenDocs\Types\RemoteMarkdownPage;
use function Internals\createGlobalPageInfoForInternals;

createGlobalPageInfoForInternals(
    'Contributing to PHP',
    copyrightInfo: CopyrightInfo::create(
        "The PHP Group",
        "https://github.com/php/php-src/blob/master/LICENSE"
    )
);

$fn = createRemoteMarkdownPageFnSectionFree(
    new RemoteMarkdownPage("https://raw.githubusercontent.com/php/php-src/master/CONTRIBUTING.md"),
);

//$fn = createRemoteMarkdownPageFn(
//    new RemoteMarkdownPage("https://raw.githubusercontent.com/php/php-src/master/CONTRIBUTING.md"),
//    'Contributing to PHP',
//    CopyrightInfo::create("The PHP Group", "https://github.com/php/php-src/blob/master/LICENSE")
//);

showPageResponse($fn);