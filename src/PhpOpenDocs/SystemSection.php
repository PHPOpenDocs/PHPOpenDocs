<?php

declare(strict_types = 1);

namespace PhpOpenDocs;

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
            new \PhpOpenDocs\SystemSectionInfo
        );
    }

    public static function create()
    {
        return new self();
    }
}
