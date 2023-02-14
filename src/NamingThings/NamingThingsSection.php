<?php

declare(strict_types = 1);

namespace NamingThings;

use OpenDocs\Section;

class NamingThingsSection extends Section
{
    public static function create(): self
    {
        return new self(
            '/naming',
            'Naming',
            'Naming things',
            new \NamingThings\NamingThingsSectionInfo,
            "https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main"
        );
    }
}
