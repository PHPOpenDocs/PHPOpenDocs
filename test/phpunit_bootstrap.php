<?php

declare(strict_types = 1);

use Auryn\Injector;
use Slim\Http\Body;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Uri;

require_once(__DIR__.'/../vendor/autoload.php');
require_once __DIR__ . '/../injectionParams/cli_test.php';
require_once __DIR__ . '/../src/functions.php';
require_once __DIR__ . '/../src/factories.php';


/**
 * @param array $testAliases
 * @return \Auryn\Injector
 */
function createInjector($testDoubles = [], $shareDoubles = [])
{
    $injectionParams = injectionParams($testDoubles);

    $injector = new \Auryn\Injector();
    $injectionParams->addToInjector($injector);

    foreach ($shareDoubles as $shareDouble) {
        $injector->share($shareDouble);
    }

    $injector->share($injector); //Yolo ServiceLocator
    return $injector;
}


///**
// * @return \Auryn\Injector
// * @throws \Auryn\ConfigException
// */
//function createTestInjector($mocks = array(), $shares = array())
//{
//    $injector = new \Auryn\Injector();
//
//    // Read application config params
//    $injectionParams = require __DIR__."/./testInjectionParams.php";
//    /** @var $injectionParams \Tier\InjectionParams */
//
//    $injectionParams->mergeMocks($mocks);
//    foreach ($mocks as $class => $implementation) {
//        if (is_object($implementation) == true) {
//            $injector->alias($class, get_class($implementation));
//            $injector->share($implementation);
//        }
//        else {
//            $injector->alias($class, $implementation);
//        }
//    }
//
//    $injectionParams->addToInjector($injector);
//    $injector->share($injector);
//
//    return $injector;
//}


function createHttpRequest(string $url)
{
    $headers = [
    ];
    $bodyContent = '';

    $cookies = [];

    $uri = Uri::createFromString($url);
    $headers = new Headers($headers);
    $serverParams = [];
    $contents = fopen('php://temp', 'r+');
    if ($contents !== false) {
        $body = new Body($contents);
        $body->write($bodyContent);
        $body->rewind();
    }
    else {
        $body = new RequestBody();
    }

    $method = 'GET';
    $request = new Request($method, $uri, $headers, $cookies, $serverParams, $body);

    return $request;
}
