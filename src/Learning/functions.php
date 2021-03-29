<?php

declare(strict_types = 1);

namespace Learning;

use OpenDocs\EditInfo;
use OpenDocs\ContentLink;


function getLearningContentLinks(): array
{
    // 'description' => "Basic resources why this not here?",
    return [
        ContentLink::level1(null, "Best practices"),
        ContentLink::level2('/best_practice_exceptions', 'Exceptions'),
        ContentLink::level2('/best_practice_interfaces_for_external_apis', "Interfaces for external apis"),
        ContentLink::level1(null, "Good docs"),
        ContentLink::level2('/java_exception_antipatterns', "Java exception anti-patterns"),
    ];
//   'path' => 'https://www.kalzumeus.com/2010/06/17/falsehoods-programmers-believe-about-names/',
//   'description' => "Falsehoods Programmers Believe About Names",

//   'path' => 'https://journal.stuffwithstuff.com/2015/02/01/what-color-is-your-function/',
//  'description' => "What Color is Your Function?",
}

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

