<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Service\MemoryWarningCheck;

use Psr\Http\Message\ServerRequestInterface as Request;

class ProdMemoryWarningCheck implements MemoryWarningCheck
{
    /** @var \PhpOpenDocs\Service\TooMuchMemoryNotifier\TooMuchMemoryNotifier */
    private $tooMuchMemoryNotifier;

    /**
     *
     * @param \PhpOpenDocs\Service\TooMuchMemoryNotifier\TooMuchMemoryNotifier $tooMuchMemoryNotifier
     */
    public function __construct(\PhpOpenDocs\Service\TooMuchMemoryNotifier\TooMuchMemoryNotifier $tooMuchMemoryNotifier)
    {
        $this->tooMuchMemoryNotifier = $tooMuchMemoryNotifier;
    }

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
