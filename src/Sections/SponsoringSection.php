<?php

declare(strict_types = 1);

namespace Sections;

use OpenDocs\Section;

class SponsoringSection extends Section
{
    public static function create()
    {
        return new self(
            '/work',
            'Work',
            'Distributing the work load required to support PHP',
            new \Work\WorkSectionInfo()
        );
    }
}
