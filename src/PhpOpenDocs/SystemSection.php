<?php

declare(strict_types = 1);

namespace PHPOpenDocs;

use OpenDocs\Section;
use OpenDocs\SectionInfo;

class SystemSection extends Section
{
    public function __construct()
    {
        parent::__construct(
            '/system',
            'System',
            'Site system stuff...',
            new \PHPOpenDocs\SystemSectionInfo,
            "https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main"
        );
    }

    public static function create(): self
    {
        return new self();
    }
}
