<?php

declare(strict_types = 1);

namespace Osf\Service;

use Osf\AdminSession\StandardAdminSession;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface;
use SlimAuryn\Response\RedirectResponse;

class ValidationExceptionFlashAndRedirect
{
    /** @var StandardAdminSession */
    private $adminSession;

    public function __construct(StandardAdminSession $adminSession)
    {
        $this->adminSession = $adminSession;
    }

    public function __invoke(
        \Params\Exception\ValidationException $ve,
        ResponseInterface $response,
        Request $request
    ) {
        $message = 'There were validation errors:<br/>';
        $message .= implode("\n", $ve->getValidationProblems());

        $this->adminSession->setFlashError($message);

        // TODO - needs query string?
        return new RedirectResponse($request->getUri()->getPath());
    }
}
