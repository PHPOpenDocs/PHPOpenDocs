<?php

declare(strict_types = 1);

namespace Internals;

use OpenDocs\Section;
use OpenDocs\SectionInfo;

class InternalsSection extends Section
{
    public function __construct()
    {
        parent::__construct(
            '/internals',
            'Internals',
            'Info about PHP core development',
            new \Internals\InternalsSectionInfo(),
            "https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main"
        );
    }

    public static function create(): self
    {
        return new self();
    }
}
