<?php

declare(strict_types = 1);

namespace Internals;

use OpenDocs\ContentLink;
use OpenDocs\CopyrightInfo;
use OpenDocs\GetRoute;
use OpenDocs\SectionInfo;

class InternalsSectionInfo implements SectionInfo
{
    /**
     * @return ContentLink[]
     */
    public function getContentLinks(): array
    {
        return [
            ContentLink::level1(null, "Technical"),
            ContentLink::level2('/', 'Overview of resources here'),
            ContentLink::level2('/useful_links', 'Links to elsewhere'),
            ContentLink::level2('/php_parameter_parsing', 'PHP Parameter parsing'),
            ContentLink::level2('/php_contributing', 'Contributing to PHP'),

            ContentLink::level1(null, "Etiquette"),
            ContentLink::level2('/mailing_list', 'Mailing list etiquette'),
            ContentLink::level2('/mailing_list_for_younguns', 'Mailing list etiquette for young\'uns'),
            ContentLink::level2('/rfc_attitudes', 'RFC attitudes'),
            ContentLink::level2('/rfc_etiquette', 'RFC etiquette'),
        ];
    }

    public function getDefaultCopyrightInfo(): CopyrightInfo
    {
        return CopyrightInfo::create(
            'PHP OpenDocs',
            'https://github.com/Danack/RfcCodex/blob/master/LICENSE'
        );
    }

    public function getRoutes()
    {
        // No routes - just php files in app/public/learning

        return [
//            new GetRoute('foo', 'Internals\Pages::getIndexPage'),
        ];
    }
}
