<?php

declare(strict_types = 1);

namespace Osf\Service\BadnessNotifier;

interface BadnessNotifier
{
    public function somethingWentWrong(string $scope, array $details);
}
