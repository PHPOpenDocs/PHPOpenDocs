<?php

//namespace Bristolian\Route;

function getAllRoutes()
{

// Each row of this array should return an array of:
// - The path to match
// - The method to match
// - The route info
// - (optional) A setup callable to add middleware/DI info specific to that route
//
// This allows use to configure data per endpoint e.g. the endpoints that should be secured by
// an api key, should call an appropriate callable.
    return [

        ['/', 'GET', 'PHPOpenDocs\AppController\Pages::index'],
        ['/about', 'GET', 'PHPOpenDocs\AppController\Pages::about'],
        ['/sections', 'GET', 'PHPOpenDocs\AppController\Pages::sections'],

        ['/tools', 'GET', 'PHPOpenDocs\AppController\ExternalPages::tools'],

        ['/privacy_policy', 'GET', 'PHPOpenDocs\AppController\Pages::privacyPolicy'],

//    ['/system', 'GET', 'PHPOpenDocs\AppController\System::indexPage'],
        ['/system/htmltest', 'GET', 'PHPOpenDocs\AppController\Pages::htmlTest'],


//    ['/system/csp_reports', 'GET', 'PHPOpenDocs\AppController\System::getReports'],
        ['/system/csp_test', 'GET', 'PHPOpenDocs\AppController\ContentSecurityPolicy::getTestPage'],

        ['/system/csp_clear', 'GET', 'PHPOpenDocs\AppController\ContentSecurityPolicy::clearReports'],

//    ['/rfc_codex{name:.+}', 'GET', 'PHPOpenDocs\AppController\Pages::rfc_codex_item'],
//    ['/rfc_codex', 'GET', 'PHPOpenDocs\AppController\Pages::rfc_codex'],

        ['/css/{any:.*}', 'GET', 'PHPOpenDocs\AppController\Pages::get404Page'],

        ['/test/caught_exception', 'GET', 'PHPOpenDocs\AppController\Debug::testCaughtException'],
        ['/test/uncaught_exception', 'GET', 'PHPOpenDocs\AppController\Debug::testUncaughtException'],
        ['/test/compile_error', 'GET', 'PHPOpenDocs\AppController\CompileError::deliberateCompileError'],


        // TODO - actually make a 404 page
        ['/{any:.*}', 'GET', 'PHPOpenDocs\AppController\Pages::get404Page'],
    ];
}



