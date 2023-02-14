<?php

declare (strict_types = 1);

/**
 * This file contains factory functions that create objects from either
 * configuration values, user input or other external data.
 *
 * We deliberately do not import most of the classes referenced in this file to the current namespace
 * as that would make it harder to read, not easier.
 */

use Psr\Http\Message\ResponseInterface;

function forbidden(\Auryn\Injector $injector): void
{
    $injector->make("Please don't use this object directly; create a more specific type to use.");
}

/**
 * Creates the objects that map StubResponse into PSR7 responses
 * @return mixed
 */
function getResultMappers(\Auryn\Injector $injector)
{
    return [
        \SlimAuryn\Response\StubResponse::class => '\SlimAuryn\ResponseMapper\ResponseMapper::mapStubResponseToPsr7',
        \OpenDocs\Page::class => 'mapOpenDocsPageToPsr7',
        ResponseInterface::class => 'SlimAuryn\ResponseMapper\ResponseMapper::passThroughResponse',
        'string' => 'convertStringToHtmlResponse',
    ];
}

function createSectionList(): \OpenDocs\SectionList
{
    $sections = [];

    $sections[] = \Learning\LearningSection::create();
    $sections[] = \NamingThings\NamingThingsSection::create();
    $sections[] = \RfcCodexOpenDocs\RfcCodexSection::create();
    $sections[] = \Sections\SponsoringSection::create(
    );
//    $sections[] = new \OpenDocs\Section(
//        '/work',
//        'Work',
//        'Distributing the work load required to support PHP',
//        new \Work\WorkSectionInfo
//    );

    $sections[] = \Internals\InternalsSection::create();

    return new \OpenDocs\SectionList($sections);
}
