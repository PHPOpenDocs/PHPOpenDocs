<?php

declare(strict_types = 1);

namespace NamingThings;

use OpenDocs\Section;

class NamingThingsSection extends Section
{
    public static function create()
    {
        return new self(
            '/naming',
            'Naming',
            'Naming things',
            new \NamingThings\NamingThingsSectionInfo
        );
    }
}
