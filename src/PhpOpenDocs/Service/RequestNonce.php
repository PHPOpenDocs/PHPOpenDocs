<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Service;

class RequestNonce
{
    /** @var string  */
    private $string;

    public function __construct()
    {
        $bytes = random_bytes(12);
        $this->string = bin2hex($bytes);
    }

    public function getRandom()
    {
        return $this->string;
    }
}
