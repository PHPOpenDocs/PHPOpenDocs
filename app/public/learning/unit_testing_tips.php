<?php

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\CopyrightInfo;
use function Learning\createRemoteMarkdownPageFn;

$copyright_info = new CopyrightInfo(
    'sarven',
    'https://github.com/sarven/unit-testing-tips/blob/main/LICENSE'
);

$fn = createRemoteMarkdownPageFn(
    "https://github.com/sarven/unit-testing-tips/raw/main/README.md",
    'Unit testing tips',
    '/unit_testing_tips',
    $copyright_info
);

showLearningResponse($fn);