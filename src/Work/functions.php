<?php

declare(strict_types = 1);

namespace Work;

use OpenDocs\EditInfo;


function createEditInfo(string $description, string $file, ?int $line): EditInfo
{
    $path = normaliseFilePath($file);

    $link = 'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/' . $path;

    if ($link !== null) {
        $link .= '#L' . $line;
    }

    return new EditInfo([$description => $link]);
}

function createEditInfo2(
    string $description1, string $file1, ?int $line1,
    string $description2, string $file2, ?int $line2
): EditInfo
{
    $path = normaliseFilePath($file1);
    $link1 = 'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/' . $path;
    if ($line1 !== null) {
        $link1 .= '#L' . $line1;
    }

    $path = normaliseFilePath($file2);
    $link2 = 'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/' . $path;
    if ($line2 !== null) {
        $link2 .= '#L' . $line2;
    }

    return new EditInfo([$description1 => $link1, $description2 => $link2]);
}

