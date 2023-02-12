<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use PHPOpenDocs\Types\RemoteMarkdownPage;
use OpenDocs\CopyrightInfo;
//use function Internals\createRemoteMarkdownPageFnEx;

$editInfo = createPHPOpenDocsEditInfo('Edit page', __FILE__, null);
$editInfo->addNameWithLink('Edit content', 'https://github.com/w9smg/.github/blob/master/profile/README.md');

echo "wat";
exit(0);

//$fn = createRemoteMarkdownPageFnEx(
//    new RemoteMarkdownPage("https://raw.githubusercontent.com/w9smg/.github/master/profile/README.md"),
//    'PHP useful links',
//    '/useful_links',
//    CopyrightInfo::create("SG", "https://github.com/w9smg/.github"),
//    $editInfo
//);

showPageResponse($fn);