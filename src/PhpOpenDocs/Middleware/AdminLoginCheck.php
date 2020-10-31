<?php

declare(strict_types = 1);

namespace PhpOpenDocs\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PhpOpenDocs\AdminSession\StandardAdminSession;

class AdminLoginCheck
{
    /** @var StandardAdminSession */
    private $session;

    public static $loginPagePaths = [
//        '/debug',
        '/login',
        // '/logout',
//        '/test/caught_exception',
//        '/test/uncaught_exception',
//        '/test/opcache'
        '/test/error_logs',

    ];

    public static $inProgressAuthLocations = [
        '/login/google2fa'
    ];

    public function __construct(StandardAdminSession $session)
    {
        $this->session = $session;
    }

    private function calculateRedirectRequired(Request $request): ?string
    {
        $path = $request->getUri()->getPath();

        // If they are logged in, but are on a non-logged in page
        // Then move them to the index
        if ($this->session->isLoggedIn() === true) {
            if (in_array($path, self::$loginPagePaths) === true) {
                return '/';
            }

            if (in_array($path, self::$inProgressAuthLocations) === true) {
                return '/';
            }

            return null;
        }

        // Otherwise they are not logged in

        // If it's a not logged in location, don't require login.
        if (in_array($path, self::$loginPagePaths) === true) {
            return null;
        }

        // If it's a not fully logged in location, don't require login.
        if (in_array($path, self::$inProgressAuthLocations) === true) {
            return null;
        }

        if (strcasecmp(PHP_SAPI, 'cli') == 0) {
            // We trust people on the command line.
            return null;
        }

        return '/login';
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        $newLocation = $this->calculateRedirectRequired($request);

        if ($newLocation !== null) {
            return $response->withStatus(302)->withHeader('Location', $newLocation);
        }

        $response = $next($request, $response);
        return $response;
    }
}
