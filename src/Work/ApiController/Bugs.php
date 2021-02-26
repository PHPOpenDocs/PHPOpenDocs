<?php

declare(strict_types = 1);

namespace Work\ApiController;

use SlimAuryn\Routes;
use SlimAuryn\Response\JsonResponse;
use PhpOpenDocs\Repo\PhpBugsStorage\PhpBugsStorage;

class Bugs
{
    public function getPhpBugsMaxComment(PhpBugsStorage $phpBugsStorage): JsonResponse
    {

        $maxCommentInfo = $phpBugsStorage->getPhpBugsMaxComment();

        if ($maxCommentInfo === null) {
            return new JsonResponse(['status' => 'no data']);
        }

        return new JsonResponse($maxCommentInfo->toArray());
    }
}
