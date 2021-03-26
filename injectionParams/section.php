<?php

use PhpOpenDocs\InjectionParams;

function getSectionInjectionParams()
{
    // These classes will only be created once by the injector.
    $shares = [
    ];

    // Alias interfaces (or classes) to the actual types that should be used
    // where they are required.
    $aliases = [
        \OpenDocs\MarkdownRenderer\MarkdownRenderer::class => \OpenDocs\MarkdownRenderer\CommonMarkRenderer::class,
    ];

    // Delegate the creation of types to callables.
    $delegates = [
    ];


    // Define some params that can be injected purely by name.
    $params = [];

    $prepares = [
    ];

    $defines = [];

    $injectionParams = new InjectionParams(
        $shares,
        $aliases,
        $delegates,
        $params,
        $prepares,
        $defines
    );

    return $injectionParams;
}
