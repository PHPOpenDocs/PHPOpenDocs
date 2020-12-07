<?php

declare(strict_types = 1);

error_reporting(E_ALL);

require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . '/factories.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/site_html.php';
require_once __DIR__ . '/slim_functions.php';

use SlimAuryn\ExceptionMiddleware;
use SlimAuryn\Routes;

set_error_handler('saneErrorHandler');

$injector = new Auryn\Injector();
$injectionParams = injectionParams();
$injectionParams->addToInjector($injector);
$injector->share($injector);

try {
    $app = $injector->make(\Slim\App::class);
    $routes = $injector->make(Routes::class);
    $routes->setupRoutes($app);
    $app->run();
}
catch (\Throwable $exception) {
    $exceptionText = null;

    try {
        $exceptionText = getExceptionText($exception);

        \error_log("Exception in code and Slim error handler failed also: " . get_class($exception) . " " . $exceptionText);
    }
    catch (\Throwable $exception) {
        // Does nothing.
    }

    http_response_code(503);
    echo "oops.";
    if ($exceptionText !== null) {
        var_dump(get_class($exception));
        echo nl2br($exceptionText);
    }
}



