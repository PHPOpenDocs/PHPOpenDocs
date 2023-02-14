<?php

declare(strict_types = 1);

namespace Sections;

use OpenDocs\Section;

class SponsoringSection extends Section
{
    public static function create(): self
    {
        return new self(
            '/sponsoring',
            'Sponsoring',
            'How to give money to people who work on PHP core or documentation.',
            new \Sponsoring\SponsoringSectionInfo(),
            "https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main"
        );
    }
}
