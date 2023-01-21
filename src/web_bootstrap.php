<?php

declare(strict_types = 1);

use Laminas\Diactoros\Request;
use Laminas\Diactoros\ServerRequest;

error_reporting(E_ALL);

require_once __DIR__ . "/includes.php";

set_error_handler('saneErrorHandler');

function showPage(\OpenDocs\Page $page)
{
    $injector = new Auryn\Injector();
    $injectionParams = injectionParams();
    $injectionParams->addToInjector($injector);
    $injector->share($injector);

    $callable = function () use ($page) {
        $html = createPageHtml(
            null,
            $page
        );

        return new \SlimAuryn\Response\HtmlResponse($html);
    };

    try {
        $container = new \Slim\Container();
        $container['request'] = function ($container) {
            $request = Request::createFromEnvironment($container->get('environment'));
            $uri = $request->getUri();
            $fakeUri = $uri->withPath('/fake_path');
            return $request->withUri($fakeUri);
        };

        $errorHandler = $injector->make(\PhpOpenDocs\AppErrorHandler\AppErrorHandler::class);
        $app = \createSlimAppForApp($injector, $container, $errorHandler);
        $app->map(['GET'], '/fake_path', $callable);

        $app->run();
    } catch (\Throwable $exception) {
        showTotalErrorPage($exception);
    }

    exit(0);
}

function showInternalsResponse($callable)
{
    $injector = new Auryn\Injector();
    $injectionParams = injectionParams();
    $injectionParams->addToInjector($injector);
    $injector->share($injector);
    $section = $injector->make(\Internals\InternalsSection::class);
    $breadcrumbsFactory = new \OpenDocs\BreadcrumbsFactory($section);
    $injector->share($breadcrumbsFactory);

    showResponseInternal($callable, $injector);
}

function showLearningResponse($callable)
{
    $injector = new Auryn\Injector();
    $injectionParams = injectionParams();
    $injectionParams->addToInjector($injector);
    $injector->share($injector);
    $section = $injector->make(\Learning\LearningSection::class);
    $breadcrumbsFactory = new \OpenDocs\BreadcrumbsFactory($section);
    $injector->share($breadcrumbsFactory);

    showResponseInternal($callable, $injector);
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

        $request =  new ServerRequest(
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
