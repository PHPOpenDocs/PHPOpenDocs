<?php

namespace ASVoting\Route;



// Each row of this array should return an array of:
// - The path to match
// - The method to match
// - The route info
// - (optional) A setup callable to add middleware/DI info specific to that route
//
// This allows use to configure data per endpoint e.g. the endpoints that should be secured by
// an api key, should call an appropriate callable.
return [
//    ['/', 'GET', 'ASVoting\ApiController\Vote::index'],



    ['/PhpBugsMaxComment', 'GET', '\Work\ApiController\Bugs::getPhpBugsMaxComment'],




//    ['/motions', 'GET', 'ASVoting\ApiController\Motions::getProposedMotions'],
//    [
//        '/motions_voting',
//        'GET',
//        'ASVoting\ApiController\Motions::getMotionsBeingVotedOn'
//    ],




//    ['/csp/test', 'GET', 'Osf\CommonController\ContentSecurityPolicy::getTestPage'],
//    ['/csp', 'POST', 'Osf\CommonController\ContentSecurityPolicy::postReport'],
//  ['/projects/{project_name:.+}', 'GET', '\Osf\AppController\Projects::getProject'],

    ['/test/caught_exception', 'GET', 'PhpOpenDocs\ApiController\Debug::testCaughtException'],
    ['/test/uncaught_exception', 'GET', 'PhpOpenDocs\ApiController\Debug::testUncaughtException'],
    ['/test/xdebug', 'GET', 'PhpOpenDocs\ApiController\Debug::testXdebugWorking'],



    ['/status', 'GET', 'PhpOpenDocs\ApiController\HealthCheck::get'],


    ['/{any:.+}', 'GET', 'PhpOpenDocs\ApiController\HealthCheck::get'],
    ['/', 'GET', 'PhpOpenDocs\ApiController\Index::getRouteList'],
];

