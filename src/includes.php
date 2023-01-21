<?php

error_reporting(E_ALL);

require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/error_functions.php';
require_once __DIR__ . '/site_html.php';
require_once __DIR__ . '/slim_functions.php';
require_once __DIR__ . "/../config.generated.php";

require_once __DIR__ . "/../app/src/app_injection_params.php";
require_once __DIR__ . '/../app/src/app_convert_exception_to_html_functions.php';
require_once __DIR__ . '/../app/src/app_factories.php';
require_once __DIR__ . '/../app/src/app_routes.php';

