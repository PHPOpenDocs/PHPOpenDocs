<?php

declare(strict_types = 1);

use Laminas\Diactoros\Request;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;

error_reporting(E_ALL);

require_once __DIR__ . "/includes.php";

set_error_handler('saneErrorHandler');

function showPage(\OpenDocs\Page $page)
{
    $callable = function () use ($page) {
        $html = createPageHtml(
            null,
            $page
        );

        return new \SlimAuryn\Response\HtmlResponse($html);
    };


    $injector = new Auryn\Injector();
    $injectionParams = injectionParams();
    $injectionParams->addToInjector($injector);
    $injector->share($injector);

    try {
        $app = $injector->make(\Slim\App::class);
        $request = (new ServerRequestFactory)->createServerRequest('GET', '/fake_path');
        $app->map(['GET'], '/fake_path', $callable);
        $app->run($request);
    } catch (\Throwable $exception) {
        showTotalErrorPage($exception);
    }

    exit(0);
}

function showPageResponse($callable)
{
    try {
        $injector = new Auryn\Injector();
        // This should be the section injection params?
        $injectionParams = injectionParams();
        $injectionParams->addToInjector($injector);
        $injector->share($injector);

        showResponseInternal($callable, $injector);
    }
    catch (\Throwable $exception) {
        showTotalErrorPage($exception);
    }
}

function showResponse($callable)
{
    $injector = new Auryn\Injector();
    $injectionParams = injectionParams();
    $injectionParams->addToInjector($injector);
    $injector->share($injector);

    showResponseInternal($callable, $injector);
}

function showResponseInternal($callable, Auryn\Injector $injector)
{
    try {
        $errorHandler = $injector->make(\PhpOpenDocs\AppErrorHandler\AppErrorHandler::class);
        $app = \createSlimAppForApp($injector, $errorHandler);
        $app->map(['GET'], '/fake_path', $callable);

        $request = new ServerRequest(
            [],
            [],
            '/fake_path',
            'GET',
            'php://temp'
        );

        $app->run($request);
    } catch (\Throwable $exception) {
        showTotalErrorPage($exception);
    }
}
