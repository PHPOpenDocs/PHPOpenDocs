<?php

declare(strict_types = 1);

namespace OpenDocs\SiteHtml;

interface SectionInfo
{
    /** @return GetRoute[] */
    public function getRoutes();
}
