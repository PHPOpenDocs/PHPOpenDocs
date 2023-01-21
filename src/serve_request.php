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


    $sectionList = createSectionList();
    foreach ($sectionList->getSections() as $section) {
        $sectionInfo = $section->getSectionInfo();
        foreach ($sectionInfo->getRoutes() as $route) {
            $fullPath = $section->getPrefix() . $route->getPath();
            $routeCallable = $route->getCallable();
            $slimRoute = $app->map([$route->getMethod()], $fullPath, $routeCallable);
        }
    }

    $routes = getAllRoutes();
    foreach ($routes as $standardRoute) {
        list($path, $method, $callable) = $standardRoute;
        $slimRoute = $app->map([$method], $path, $callable);
    }


    $app->run();
}
catch (\Throwable $exception) {
    showTotalErrorPage($exception);
}
