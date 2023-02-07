<?php

declare(strict_types = 1);

namespace RfcCodexOpenDocs;

use OpenDocs\EditInfo;
use OpenDocs\ContentLink;
use OpenDocs\CopyrightInfo;
use OpenDocs\GlobalPageInfo;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\ExternalMarkdownRenderer\ExternalMarkdownRenderer;
use OpenDocs\BreadcrumbsFactory;
use OpenDocs\Page;
use function Learning\createLearningDefaultCopyrightInfo;
use function Learning\getLearningContentLinks;


function getCodexEntry(string $name): RfcCodexEntry|null
{
    foreach (getUnderDiscussionList() as $codexEntry) {
        if ($codexEntry->getPath() === $name) {
            return $codexEntry;
        }
    }

    foreach (getAchievedList() as $codexEntry) {
        if ($codexEntry->getPath() === $name) {
            return $codexEntry;
        }
    }
    return null;
}

function getTitleFromFileName(string $name)
{
    $codexEntry = getCodexEntry($name);

    if ($codexEntry === null) {
        return null;
    }

    return $codexEntry->getName();
}

/**
 * @return RfcCodexEntry[]
 */
function getUnderDiscussionList()
{
    $under_discussion_list = [
        ['Array key casting', 'array_key_casting.md'],
        ['Auto-capture closure aka multi-line blocks', 'auto_capture_closure.md'],
        ['Better web sapi', 'better_web_sapi.md'],
        ['Call site error or exception control', 'call_site_error_exception_control.md'],
        ['Chained comparison operators', 'chained_comparison_operators.md'],
        ['Class method callable', 'class_method_callable.md'],
        ['Class scoping improvements', 'class_scoping_improvements.md'],
        ['Closure self-reference', 'closure_self_reference.md'],
        ['Consistent callables', 'consistent_callables.md'],
        ['Generics', 'generics.md'],
        ['Method overloading', 'method_overloading.md'],
        ['Out parameters', 'out_parameters.md'],
        ['Pipe operator', 'pipe_operator.md'],
        ['Standardise core library', 'standardise_core_library.md'],
        ['Static class initialization', 'static_class_init.md'],
        ['Strict mode and internal engine callbacks', 'engine_strict_mode_interaction.md'],
        ['Strings/encoding is terrible', 'strings_and_encoding.md'],
        ['Strong typing', 'strong_typing.md'],
        ['Structs', 'structs.md'],
        ['Template string literals', 'template_literals.md'],
        ['Throws declarations', 'throws_declaration.md'],
        ['Tuple return declarations', 'tuple_returns.md'],
        ['Type aliasing', 'type_aliasing.md'],
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
        ['Immutables', 'immutable.md'],
        ['Named params', 'named_params.md'],
//        ['Null short-circuiting', 'https://wiki.php.net/rfc/nullsafe_operator'],
        ['Null type', 'null_type.md'],
        ['Referencing functions', 'referencing_functions.md'],
        ['Ternary right associative', 'ternary_operator_right_associative.md'],
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

//function createEditInfo(string $description, string $file, ?int $line): EditInfo
//{
//    $path = normaliseFilePath($file);
//
//    $link = 'https://github.com/Danack/RfcCodex/blob/main/' . $path;
//
//    if ($link !== null) {
//        $link .= '#L' . $line;
//    }
//
//    return new EditInfo([$description => $link]);
//}

function createRfcCodexDefaultCopyrightInfo()
{
    return new CopyrightInfo(
        'PHP OpenDocs',
        'https://github.com/Danack/RfcCodex/blob/master/LICENSE'
    );
}


function createGlobalPageInfoForRfcCodex(
    string $html = null,
    string $title = null
) {
    GlobalPageInfo::create(
        contentHtml: $html,
        contentLinks: getRfcCodexContentLinks() ,
        copyrightInfo: createRfcCodexDefaultCopyrightInfo(),
        section: \RfcCodexOpenDocs\RfcCodexSection::create(),
        title: $title,
        current_path: getRequestPath(),
    );

//    $prefix = GlobalPageInfo::getSection()->getPrefix();
//
//    $request_path = getRequestPath();
//
//    if (str_starts_with($request_path, $prefix) === true) {
//        $request_path = substr($request_path, strlen($prefix));
//    }
//
//    GlobalPageInfo::setPrevNextLinks(
//        createPrevNextLinksFromContentLinks(getRfcCodexContentLinks(), $request_path)
//    );

    GlobalPageInfo::addEditInfoFromBacktrace('Edit page', 1);
}
