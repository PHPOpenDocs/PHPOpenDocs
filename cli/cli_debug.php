<?php

use ASVoting\CLIFunction;

error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/factories.php';
require __DIR__ . '/../src/exception_mappers_cli.php';
require __DIR__ . "/../src/cli_functions.php";

CLIFunction::setupErrorHandlers();

if (isset($callable) !== true || isset($params) !== true) {
  echo "Please set \$callable and \$params in the file that includes this one.";
  exit(-1);
}

$actualAliases = [];

if (isset($aliases) === true) {
    /** @var $aliases array */
    $actualAliases = $aliases;
}


if (isset($body) !== true) {
    $body = null;
}

/** @var  $callable callable */
/** @var  $params array */

$result = runSomething($callable, $params, $actualAliases, $body);

if ($result instanceof \SlimAuryn\Response\StubResponse) {
    echo $result->getBody();
}
else {

    var_dump($result);
}
