<?php

declare(strict_types = 1);

namespace Osf\Service\EmailClient;

use Osf\MandrillConfig;

class MandrillEmailClient implements EmailClient
{
    private $mandrillConfig;

    public function sendTextEmail(string $emailAddress, string $subject, string $bodyText)
    {
        throw new \Exception("sendTextEmail not implemented yet.");
    }
}
