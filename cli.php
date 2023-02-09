#!/usr/bin/env php
<?php

use Danack\Console\Application;
use Danack\Console\Output\BufferedOutput;
use PHPOpenDocs\CLIFunction;
use VarMap\VarMap;
use VarMap\ArrayVarMap;

error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/factories.php';
require __DIR__ . '/src/functions.php';
require __DIR__ . '/src/error_functions.php';
require __DIR__ . '/src/exception_mappers_cli.php';
require __DIR__ . "/cli/cli_commands.php";
require __DIR__ . "/config.generated.php";


set_time_limit(20);

$injector = new Auryn\Injector();

CLIFunction::setupErrorHandlers();

$cliInjectionParams = require __DIR__ . "/injectionParams/cli.php";
$cliInjectionParams->addToInjector($injector);

$injector->share($injector);

$console = new Application();
add_console_commands($console);

try {
    $parsedCommand = $console->parseCommandLine();
}
catch (\Exception $e) {

    echo getTextForException($e);
    echo "\n";
//    $output = new BufferedOutput();
//    $console->renderException($e, $output);
//    echo $output->fetch();
    exit(-1);
}


$exceptionMappers = [
    Auryn\InjectionException::class => 'cliHandleInjectionException',
];

try {
    foreach ($parsedCommand->getParams() as $key => $value) {
        $injector->defineParam($key, $value);
    }

    $variableMap = new ArrayVarMap($parsedCommand->getParams());
    $injector->alias(VarMap::class, get_class($variableMap));
    $injector->share($variableMap);

    $injector->execute($parsedCommand->getCallable());
    echo "\n";
}


catch (\Exception $e) {

    foreach ($exceptionMappers as $exceptionType => $handler) {
        if ($e instanceof $exceptionType) {
            $handler($console, $e);
            return;
        }
    }

    cliHandleGenericException($console, $e);
}
