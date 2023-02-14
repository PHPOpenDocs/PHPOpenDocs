<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PHPOpenDocs\Types\PackageMarkdownPage;
use function Learning\createGlobalPageInfoForLearning;

createGlobalPageInfoForLearning('PHP for people who know how to program');

$fn = createMarkdownPackagePageFnSectionFree(
    PackageMarkdownPage::Learning("src/Learning/docs/php_for_people_who_know_how_to_code.md"),
);

showResponse($fn);