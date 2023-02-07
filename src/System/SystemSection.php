<?php

declare(strict_types = 1);

namespace System;

use OpenDocs\Section;

class SystemSection extends Section
{
    public function __construct()
    {
        parent::__construct(
            '/system',
            'System stuff',
            "Really, stuff to do with the system",
            new \PhpOpenDocs\SystemSectionInfo()
        );
    }

    public static function create()
    {
        return new self();
    }
}
