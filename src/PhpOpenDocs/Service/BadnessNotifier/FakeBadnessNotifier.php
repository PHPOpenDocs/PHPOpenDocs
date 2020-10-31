<?php

declare(strict_types = 1);

namespace Osf\Service\BadnessNotifier;

class FakeBadnessNotifier implements BadnessNotifier
{
    public function somethingWentWrong(string $scope, array $details)
    {
        // todo - replace with a better version.
    }
}
