<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PHPOpenDocs\Types\PackageMarkdownPage;
use function Learning\createGlobalPageInfoForLearning;

createGlobalPageInfoForLearning('Best practice shorts');

$fn = createMarkdownPackagePageFnSectionFree(
    PackageMarkdownPage::Learning("src/Learning/docs/best_practice_shorts.md"),
);

showPageResponse($fn);