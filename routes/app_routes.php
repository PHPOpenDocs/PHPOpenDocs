<?php

namespace PhpOpenDocs\Route;

// Each row of this array should return an array of:
// - The path to match
// - The method to match
// - The route info
// - (optional) A setup callable to add middleware/DI info specific to that route
//
// This allows use to configure data per endpoint e.g. the endpoints that should be secured by
// an api key, should call an appropriate callable.
return [


    ['/', 'GET', 'PhpOpenDocs\AppController\Pages::index'],

    ['/about', 'GET', 'PhpOpenDocs\AppController\Pages::about'],

    ['/rfc_codex{name:.+}', 'GET', 'PhpOpenDocs\AppController\Pages::rfc_codex_item'],
    ['/rfc_codex', 'GET', 'PhpOpenDocs\AppController\Pages::rfc_codex'],

    ['/css/{any:.*}', 'GET', 'PhpOpenDocs\AppController\Pages::get404Page'],

    ['/test/caught_exception', 'GET', 'PhpOpenDocs\AppController\Debug::testCaughtException'],
    ['/test/uncaught_exception', 'GET', 'PhpOpenDocs\AppController\Debug::testUncaughtException'],
    ['/test/compile_error', 'GET', 'PhpOpenDocs\AppController\CompileError::deliberateCompileError'],

    // TODO - actually make a 404 page
    ['/{any:.*}', 'GET', 'Osf\AppController\Pages::index'],
];





//    ['/test/compile_error', 'GET', '\Osf\CommonController\CompileError::deliberateCompileError'],

//    ['/faq', 'GET', 'Osf\AppController\Pages::faq'],
//
//    ['/privacy_policy', 'GET', 'Osf\AppController\Pages::privacyPolicy'],
//
//
//
//
//    ['/csp/test', 'GET', 'Osf\CommonController\ContentSecurityPolicy::getTestPage'],
//    ['/csp', 'POST', 'Osf\CommonController\ContentSecurityPolicy::postReport'],
//
