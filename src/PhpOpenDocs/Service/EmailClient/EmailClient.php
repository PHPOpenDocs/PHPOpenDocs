<?php

declare(strict_types = 1);

namespace Osf\Service\EmailClient;

interface EmailClient
{
    public function sendTextEmail(
        string $emailAddress,
        string $subject,
        string $bodyText
    );
}
