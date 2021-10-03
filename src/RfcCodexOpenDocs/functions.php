<?php

declare(strict_types = 1);

namespace RfcCodexOpenDocs;

use OpenDocs\EditInfo;
use OpenDocs\ContentLink;
use OpenDocs\CopyrightInfo;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\ExternalMarkdownRenderer\ExternalMarkdownRenderer;
use OpenDocs\BreadcrumbsFactory;
use OpenDocs\Page;

function createPageFn(
    string $markdown_path,
    string $title,
    string $current_path
) {
    $breadcrumbs = [$current_path => $title];

    return function (
        RfcCodexSection $section,
        MarkdownRenderer $markdownRenderer,
        BreadcrumbsFactory $breadcrumbsFactory
    ) use (
        $markdown_path,
        $title,
        $breadcrumbs,
        $current_path
    ) {
        $fullPath = $markdown_path;
        $html = $markdownRenderer->renderFile($fullPath);

        $contentLinks = getRfcCodexContentLinks();
        $editInfo = createPHPOpenDocsEditInfo('Edit page', __FILE__, null);

        $page = Page::createFromHtmlEx2(
            $title,
            $html,
            $editInfo,
            $breadcrumbsFactory->createFromArray($breadcrumbs),
            createRfcCodexDefaultCopyrightInfo(),
            createLinkInfo($current_path, $contentLinks),
            $section
        );

        return $page;
    };
}

function createRemoteMarkdownPageFn(
    string $markdown_url,
    string $title,
    string $current_path,
    CopyrightInfo $copyright_info
) {
    $breadcrumbs = [$current_path => $title];

    return function (
        RfcCodexSection $section,
        ExternalMarkdownRenderer $markdownRenderer,
        BreadcrumbsFactory $breadcrumbsFactory
    ) use (
        $markdown_url,
        $title,
        $breadcrumbs,
        $current_path,
        $copyright_info
    ) {

        $html = $markdownRenderer->renderUrl($markdown_url);

        $contentLinks = getRfcCodexContentLinks();
        $editInfo = createPHPOpenDocsEditInfo('Edit page', __FILE__, null);

        $page = Page::createFromHtmlEx2(
            $title,
            $html,
            $editInfo,
            $breadcrumbsFactory->createFromArray($breadcrumbs),
            $copyright_info,
            createLinkInfo($current_path, $contentLinks),
            $section
        );

        return $page;
    };
}

/**
 * @return RfcCodexEntry[]
 */
function getUnderDiscussionList()
{
    $under_discussion_list = [
        ['Better web sapi', 'better_web_sapi.md'],
        ['Call site error or exception control', 'call_site_error_exception_control.md'],
        ['Class scoping improvements', 'class_scoping_improvements.md'],
        ['Consistent callables', 'consistent_callables.md'],
        ['Generics', 'generics.md'],
        ['Immutable', 'immutable.md'],
        ['Method overloading', 'method_overloading.md'],
        ['Out parameters', 'out_parameters.md'],
        ['Standardise core library', 'standardise_core_library.md'],
        ['Static class initialization', 'static_class_init.md'],
        ['Strings/encoding is terrible', 'strings_and_encoding.md'],
        ['Strong typing', 'strong_typing.md'],
        ['Structs', 'structs.md'],
        ['Ternary right associative', 'ternary_operator_right_associative.md'],
        ['Throws declarations', 'throws_declaration.md'],
        ['Typedef callable signatures', 'typedef_callables.md'],
    ];

    $entries = [];

    foreach ($under_discussion_list as $under_discussion) {
        $entries[] = new RfcCodexEntry(
            $under_discussion[0],
            $under_discussion[1]
        );
    }

    return $entries;
}


/**
 * @return RfcCodexEntry[]
 */
function getAchievedList()
{
    $achieved_entries_list = [
        ['Annotations', 'annotations.md'],
        ['Briefer closure syntax', 'briefer_closure_syntax.md'],
        ['Co- and contra-variance', 'co_and_contra_variance.md'],
        ['Enums', 'enums.md'],
        ['Named params', 'named_params.md'],
//        ['Null short-circuiting', 'https://wiki.php.net/rfc/nullsafe_operator'],
        ['Referencing functions', 'referencing_functions.md'],
        ['Union types', 'union_types.md'],
    ];

    $entries = [];

    foreach ($achieved_entries_list as $entry) {
        $entries[] = new RfcCodexEntry(
            $entry[0],
            $entry[1]
        );
    }

    return $entries;
}


function getRfcCodexContentLinks(): array
{
    $links = [];

    $links[] = ContentLink::level1(null, 'Under discussion');
    foreach (getUnderDiscussionList() as $under_discussion_entry) {
        $links[] = ContentLink::level2(
            '/' . $under_discussion_entry->getPath(),
            $under_discussion_entry->getName()
        );
    }

    $links[] = ContentLink::level1(null, 'Ideas that overcame their challenges');
    foreach (getAchievedList() as $achieved_entry) {
        $links[] = ContentLink::level2(
            '/' . $achieved_entry->getPath(),
            $achieved_entry->getName()
        );
    }


    return $links;
}

function createEditInfo(string $description, string $file, ?int $line): EditInfo
{
    $path = normaliseFilePath($file);

    $link = 'https://github.com/Danack/RfcCodex/blob/main/' . $path;

    if ($link !== null) {
        $link .= '#L' . $line;
    }

    return new EditInfo([$description => $link]);
}

function createRfcCodexDefaultCopyrightInfo()
{
    return new CopyrightInfo(
        'PHP OpenDocs',
        'https://github.com/Danack/RfcCodex/blob/master/LICENSE'
    );
}

function showRfcCodexResponse($callable)
{
    $injector = new \Auryn\Injector();
    $injectionParams = injectionParams();
    $injectionParams->addToInjector($injector);
    $injector->share($injector);
    $section = $injector->make(\RfcCodexOpenDocs\RfcCodexSection::class);
    $breadcrumbsFactory = new \OpenDocs\BreadcrumbsFactory($section);
    $injector->share($breadcrumbsFactory);

    showResponseInternal($callable, $injector);
}
