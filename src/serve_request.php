<?php

declare(strict_types = 1);

require_once __DIR__ . "/includes.php";

set_error_handler('saneErrorHandler');

$injector = new Auryn\Injector();
$injectionParams = injectionParams();
$injectionParams->addToInjector($injector);
$injector->share($injector);

try {
    $app = $injector->make(\Slim\App::class);
    setupAllRoutes($app);

    $app->run();
}
catch (\Throwable $exception) {
    showTotalErrorPage($exception);
}
