<?php

declare(strict_types = 1);

namespace NamingThings;

use OpenDocs\GetRoute;
use OpenDocs\SectionInfo;

class NamingThingsSectionInfo implements SectionInfo
{
    public function getRoutes()
    {
        return [
            new GetRoute('/nouns', 'NamingThings\Pages::getNounsPage'),
            new GetRoute('/verbs', 'NamingThings\Pages::getVerbsPage'),
            new GetRoute('', 'NamingThings\Pages::getIndexPage'),
        ];
    }
}
