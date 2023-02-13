<?php

declare(strict_types = 1);

namespace NamingThings;

use OpenDocs\ContentLink;
use OpenDocs\CopyrightInfo;
use OpenDocs\GetRoute;
use OpenDocs\SectionInfo;

class NamingThingsSectionInfo implements SectionInfo
{
    /**
     * @return ContentLink[]
     */
    public function getContentLinks(): array
    {
        return [
            ContentLink::Level1(null, "Naming things"),
            ContentLink::Level2("/nouns", "Nouns"),
            ContentLink::Level2("/verbs", "Verbs"),
        ];
    }

    public function getDefaultCopyrightInfo(): CopyrightInfo
    {
        return CopyrightInfo::create(
            'PHP OpenDocs',
            'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/LICENSE'
        );
    }

    public function getRoutes()
    {
        return [
            new GetRoute('/nouns', 'NamingThings\Pages::getNounsPage'),
            new GetRoute('/verbs', 'NamingThings\Pages::getVerbsPage'),
            new GetRoute('', 'NamingThings\Pages::getIndexPage'),
        ];
    }
}
