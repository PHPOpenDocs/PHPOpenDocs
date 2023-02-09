<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PHPOpenDocs\Types\PackageMarkdownPage;
use function Learning\createMarkdownPackagePageFnLearning;

$fn = createMarkdownPackagePageFnLearning(
    PackageMarkdownPage::Learning("docs/best_practice_shorts.md"),
    'Best practice shorts',
);

showPageResponse($fn);