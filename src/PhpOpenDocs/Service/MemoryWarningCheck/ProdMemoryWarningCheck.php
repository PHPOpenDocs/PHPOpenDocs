<?php

declare(strict_types = 1);

namespace PHPOpenDocs\Service\MemoryWarningCheck;

use Psr\Http\Message\ServerRequestInterface as Request;

class ProdMemoryWarningCheck implements MemoryWarningCheck
{
//    /** @var \PHPOpenDocs\Service\TooMuchMemoryNotifier\TooMuchMemoryNotifier */
//    private $tooMuchMemoryNotifier;

//    /**
//     *
//     * @param \PHPOpenDocs\Service\TooMuchMemoryNotifier\TooMuchMemoryNotifier $tooMuchMemoryNotifier
//     */
//    public function __construct(TooMuchMemoryNotifier $tooMuchMemoryNotifier)
//    {
//        $this->tooMuchMemoryNotifier = $tooMuchMemoryNotifier;
//    }

    public function checkMemoryUsage(Request $request) : int
    {
        $percentMemoryUsed = getPercentMemoryUsed();

        if ($percentMemoryUsed > 50) {
            $message = sprintf(
                "Request is using too much memory. Path was [%s]",
                $request->getUri()->getPath()
            );

            \error_log($message);
        }

        return $percentMemoryUsed;
    }
}
