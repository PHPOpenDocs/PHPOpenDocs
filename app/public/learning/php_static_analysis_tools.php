<?php

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\CopyrightInfo;
use PHPOpenDocs\Types\RemoteMarkdownPage;
use function Learning\createGlobalPageInfoForLearning;

createGlobalPageInfoForLearning(
    title: 'PHP static analysis_tools',
    copyrightInfo: CopyrightInfo::create(
        'exakat',
        'https://github.com/exakat/php-static-analysis-tools/blob/master/LICENSE.md'
    )
);

$fn = createRemoteMarkdownPageFnSectionFree(
    new RemoteMarkdownPage("https://raw.githubusercontent.com/exakat/php-static-analysis-tools/master/README.md"),
);

showPageResponse($fn);