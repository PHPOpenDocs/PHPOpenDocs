<?php

declare(strict_types = 1);

namespace RfcCodexOpenDocs;


use OpenDocs\ContentLinks;
use OpenDocs\FooterInfo;
use OpenDocs\Page;
use OpenDocs\Section;
use OpenDocs\PrevNextLinks;
use OpenDocs\URL;
use OpenDocs\ContentLinkLevel1;
use OpenDocs\ContentLinkLevel2;
use OpenDocs\MarkdownRenderer;


class Pages {

    private MarkdownRenderer $markdownRenderer;

    /**
     * @var RfcCodexEntry[]
     */
    private array $under_discussion_entries = [];


    /**
     * @var RfcCodexEntry[]
     */
    private array $achieved_entries = [];

    public function __construct(MarkdownRenderer $markdownRenderer)
    {
        $this->markdownRenderer = $markdownRenderer;
        $this->init();
    }


    private function init()
    {
        $under_discussion_list = [
            ['Better web sapi', 'better_web_sapi.md'],
            ['Call site error or exception control', 'call_site_error_exception_control.md'],
            ['Class scoping improvements', 'class_scoping_improvements.md'],
            ['Consistent callables', 'consistent_callables.md'],
            ['Enums', 'enums.md'],
            ['Generics', 'generics.md'],
            ['Immutable', 'immutable.md'],
            ['Method overloading', 'method_overloading.md'],
            ['Out parameters', 'out_parameters.md'],
            ['Referencing functions', 'referencing_functions.md'],
            ['Standardise core library', 'standardise_core_library.md'],
            ['Strings/encoding is terrible', 'strings_and_encoding.md'],
            ['Strong typing', 'strong_typing.md'],
            ['Structs', 'structs.md'],
            ['Ternary right associative', 'ternary_operator_right_associative.md'],
            ['Throws declarations', 'throws_declaration.md'],
            ['Typedef callable signatures', 'typedef_callables.md'],
        ];

        foreach ($under_discussion_list as $under_discussion) {
            $this->under_discussion_entries[] = new RfcCodexEntry(
                $under_discussion[0],
                $under_discussion[1]
            );
        }

        $achived_entries_list = [
            ['Annotations', 'annotations.md'],
            ['Briefer closure syntax', 'briefer_closure_syntax.md'],
            ['Co- and contra-variance', 'co_and_contra_variance.md'],
            ['Named params', 'named_params.md'],
            ['Null short-circuiting', 'https://wiki.php.net/rfc/nullsafe_operator'],
            ['Union types', 'union_types.md'],
        ];

        foreach ($achived_entries_list as $achieved) {
            $this->achieved_entries[] = new RfcCodexEntry(
                $achieved[0],
                $achieved[1]
            );
        }
    }

    private function makeList(string $name, $items)
    {

        $list = [];
        foreach ($items as $entry) {

            $url = $entry->getFilename();
            if (strpos($url, 'http') !== 0) {
                $url = '/' . $entry->getPath();
            }

            $list[] = new ContentLinkLevel2(
                $url,
                $entry->getName(),
                null
            );
        }

        return new ContentLinkLevel1(
            null,
            $name,
            $list
        );
    }

    public function getContentLinks(): ContentLinks
    {
        $underDiscussion = $this->makeList(
            'Under discussion',
            $this->under_discussion_entries
        );

        $achieved = $this->makeList(
            'Ideas that overcame their challenges',
            $this->achieved_entries
        );


        return new ContentLinks([$underDiscussion, $achieved]);
    }


    private function getContentsFromList($name, $list): ?string
    {
        foreach ($list as $entry) {
            if ($name === $entry->getPath() || $name === $entry->getFilename()) {
                $fullPath = __DIR__ . "/../../vendor/danack/rfc-codex/" . $entry->getFilename();
                $markdown = file_get_contents($fullPath);
                return $this->markdownRenderer->render($markdown);
            };
        }

        return null;
    }

    private function getContents($name): ?string
    {
        $contents = $this->getContentsFromList($name, $this->under_discussion_entries);
        if ($contents !== null) {
            return $contents;
        }

        $contents = $this->getContentsFromList($name, $this->achieved_entries);
        if ($contents !== null) {
            return $contents;
        }

        return null;
    }

    public function getPage(Section $section, $name): Page
    {
        $contents = $this->getContents($name);

        if ($contents === null) {
            // TODO
            $contents = "This should be a 404 page.";
        }

        return new Page(
            'Rfc Codex - ' . $name,
            new URL('https://github.com/danack/RfcCodex'),
            $this->getContentLinks(),
            new PrevNextLinks(null, null),
            $contents,
            'Danack',
        );
    }


    public function getIndexPage(Section $section): Page
    {
        $fullPath = __DIR__ . "/../../vendor/danack/rfc-codex/rfc_codex.md";
        $markdown = file_get_contents($fullPath);
        $contents = $this->markdownRenderer->render($markdown);

        $contents = str_replace(
            "https://github.com/Danack/RfcCodex/blob/master",
            $section->getPrefix(),
            $contents
        );

        return new Page(
            'Rfc Codex',
            new URL('https://github.com/danack/RfcCodex'),
            $this->getContentLinks(),
            new PrevNextLinks(null, null),
            $contents,
            'Danack',
        );
    }
}


