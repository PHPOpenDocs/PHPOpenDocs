<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Key;

class ContentSecurityPolicyKey
{
    /**
     * @param string $key
     * @return string
     */
    public static function getAbsoluteKeyName(string $key) : string
    {
        return __CLASS__ . '_' . $key;
    }
}
