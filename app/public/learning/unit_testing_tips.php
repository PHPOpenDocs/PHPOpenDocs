<?php

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\CopyrightInfo;
use PHPOpenDocs\Types\RemoteMarkdownPage;
use function Internals\createGlobalPageInfoForInternals;

//$copyright_info = CopyrightInfo::create(
//    'sarven',
//    'https://github.com/sarven/unit-testing-tips/blob/main/LICENSE'
//);
//
//$fn = createRemoteMarkdownPageFn(
//    "https://github.com/sarven/unit-testing-tips/raw/main/README.md",
//    'Unit testing tips',
//    '/unit_testing_tips',
//    $copyright_info
//);

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