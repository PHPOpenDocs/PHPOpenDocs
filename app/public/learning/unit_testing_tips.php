<?php

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\CopyrightInfo;
use PHPOpenDocs\Types\RemoteMarkdownPage;
use function Internals\createGlobalPageInfoForInternals;

createGlobalPageInfoForInternals(
    'Unit testing tips',
    copyrightInfo: CopyrightInfo::create(
        'sarven',
        'https://github.com/sarven/unit-testing-tips/blob/main/LICENSE'
    )
);

$fn = createRemoteMarkdownPageFnSectionFree(
    new RemoteMarkdownPage("https://github.com/sarven/unit-testing-tips/raw/main/README.md"),
);

showResponse($fn);