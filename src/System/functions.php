<?php

declare(strict_types = 1);

use OpenDocs\ContentLink;
use OpenDocs\GlobalPageInfo;
use PHPOpenDocs\SystemSection;
use function Internals\createInternalsDefaultCopyrightInfo;
use function Internals\getInternalsContentLinks;

function createGlobalPageInfoForSystem(
    string $html = null,
    string $title = null
): void {
    GlobalPageInfo::create(
        contentHtml: $html,
        contentLinks: getSystemContentLinks(),
        copyrightInfo: createDefaultCopyrightInfo(),
        section: \System\SystemSection::create(),
        title: $title,
        current_path: getRequestPath(),
    );
}


function getSystemContentLinks(): array
{
    return [
        ContentLink::level1(null, "Sytem"),
        ContentLink::level2('/', 'System info'),
        ContentLink::level2('/csp_violations', 'CSP violations'),
        ContentLink::level2('/exception_test', 'Exception test'),
        ContentLink::level2('/brain_dump', 'Brain dump'),
    ];
}
