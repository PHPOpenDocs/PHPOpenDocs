<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../../src/web_bootstrap.php";

use PHPOpenDocs\Types\PackageMarkdownPage;
use function Learning\createGlobalPageInfoForLearning;

createGlobalPageInfoForLearning('Debugging with valgrind');

$fn = createMarkdownPackagePageFnSectionFree(
    PackageMarkdownPage::Learning("src/Learning/docs/valgrind.md"),
);


showResponse($fn);
