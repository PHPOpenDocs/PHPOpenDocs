<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\CopyrightInfo;
use PHPOpenDocs\Types\PackageMarkdownPage;
use function Learning\createGlobalPageInfoForLearning;

createGlobalPageInfoForLearning(
    'Java Exception Antipatterns',
    CopyrightInfo::create(
        'Java Exception Antipatterns',
        "Needs to be set"
    )
);


$fn = createMarkdownPackagePageFnSectionFree(
    PackageMarkdownPage::Learning("docs/archive_java_exception_antipatterns.md"),
);

showPageResponse($fn);
