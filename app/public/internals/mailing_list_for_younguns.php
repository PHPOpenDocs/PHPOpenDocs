<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PhpOpenDocs\Types\PackageMarkdownPage;
use function Internals\createMarkdownPackagePageFnInternals;

$fn = createMarkdownPackagePageFnInternals(
    PackageMarkdownPage::RfcCodex("etiquette/mailing_list_for_younguns.md"),
    'Mailing list etiquette for young\'uns',
    '/mailing_list_for_younguns'
);

showPageResponse($fn);