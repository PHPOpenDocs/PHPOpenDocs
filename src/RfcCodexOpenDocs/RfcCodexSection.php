<?php

declare(strict_types = 1);

namespace RfcCodexOpenDocs;

use OpenDocs\Section;

class RfcCodexSection extends Section
{
    public function __construct()
    {
        parent::__construct(
            '/rfc_codex',
            'RFC Codex',
            "Discussions ideas for how PHP can be improved, why some ideas haven't come to fruition yet.",
            new \RfcCodexOpenDocs\RfcCodexSectionInfo(),
            //            'https://github.com/PHPOpenDocs/PHPOpenDocs/tree/main'
            'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main'
        );
    }

    public static function create(): self
    {
        return new self();
    }
}
