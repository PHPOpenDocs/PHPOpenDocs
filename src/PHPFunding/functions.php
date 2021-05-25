<?php

declare(strict_types=1);

namespace PHPFunding;

use OpenDocs\ContentLink;
use OpenDocs\EditInfo;
use OpenDocs\GetRoute;

function createEditInfo(string $description, string $file, ?int $line): EditInfo
{
    $path = normaliseFilePath($file);

    $link = 'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/' . $path;

    if ($link !== null) {
        $link .= '#L' . $line;
    }

    return new EditInfo([$description => $link]);
}

function getFundingContentLinks(): array
{
    return [
        ContentLink::level1('/', "Sponsoring"),
        ContentLink::level2('/internals', 'Internals'),
        ContentLink::level2('/extensions', 'Extensions'),
        ContentLink::level2('/userland', 'Userland'),
    ];
}



