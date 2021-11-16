<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use function Internals\createPageFn;


use OpenDocs\CopyrightInfo;
use function Internals\createRemoteMarkdownPageFn;

$fn = createRemoteMarkdownPageFn(
    "https://raw.githubusercontent.com/w9smg/.github/master/profile/README.md",
    'PHP useful links',
    '/useful_links',
    new CopyrightInfo("SG", "https://github.com/w9smg/.github")
);

