<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PhpOpenDocs\Types\PackageMarkdownPage;
use function Learning\createMarkdownPackagePageFnLearning;

$fn = createMarkdownPackagePageFnLearning(
    PackageMarkdownPage::Learning("docs/best_practice_exceptions.md"),
    'Best practice exceptions',
);


showResponse($fn);