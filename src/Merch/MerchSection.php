<?php

declare(strict_types = 1);

namespace Merch;

use OpenDocs\Section;

class MerchSection extends Section
{
    public static function create()
    {
        return new self(
            '/merch',
            'Merch',
            'PHP related things to buy',
            new \Merch\MerchSectionInfo()
        );
    }
}
