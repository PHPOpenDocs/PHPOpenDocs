<?php

declare(strict_types = 1);

namespace PHPOpenDocs\ApiController;

use SlimAuryn\Response\JsonResponse;

class HealthCheck
{
    public function get(): JsonResponse
    {
        return new JsonResponse(['ok']);
    }
}
