<?php

declare(strict_types = 1);

namespace RfcCodexOpenDocs;

use OpenDocs\Breadcrumb;
use OpenDocs\Breadcrumbs;
use OpenDocs\CopyrightInfo;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\Page;
use OpenDocs\PrevNextLinks;
use OpenDocs\ContentLink;
use PhpOpenDocs\RfcCodexSection;

class Pages
{
    private MarkdownRenderer $markdownRenderer;

    /**
     * @var RfcCodexEntry[]
     */
    private array $under_discussion_entries = [];

    /**
     * @var RfcCodexEntry[]
     */
    private array $achieved_entries = [];


    /**
     * @var RfcCodexEntry[]
     */
    private array $all_entries = [];

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
            $entry = new RfcCodexEntry(
                $under_discussion[0],
                $under_discussion[1]
            );

            $this->under_discussion_entries[] = $entry;
            $this->all_entries[] = $entry;
        }

        $achieved_entries_list = [
            ['Annotations', 'annotations.md'],
            ['Briefer closure syntax', 'briefer_closure_syntax.md'],
            ['Co- and contra-variance', 'co_and_contra_variance.md'],
            ['Enums', 'enums.md'],
            ['Named params', 'named_params.md'],
            ['Null short-circuiting', 'https://wiki.php.net/rfc/nullsafe_operator'],
            ['Union types', 'union_types.md'],
        ];

        foreach ($achieved_entries_list as $achieved) {
            $entry = new RfcCodexEntry(
                $achieved[0],
                $achieved[1]
            );

            $this->achieved_entries[] = $entry;
            $this->all_entries[] = $entry;
        }
    }


    /**
     * @return ContentLink[]
     */
    public function getContentLinks(): array
    {
        $links = [];

        $links[] = ContentLink::level1(null, 'Under discussion');

        foreach ($this->under_discussion_entries as $under_discussion_entry) {
            $links[] = ContentLink::level2(
                '/' . $under_discussion_entry->getPath(),
                $under_discussion_entry->getName()
            );
        }

        $links[] = ContentLink::level1(null, 'Ideas that overcame their challenges');
        ;
        foreach ($this->achieved_entries as $achieved_entry) {
            $links[] = ContentLink::level2(
                '/' . $achieved_entry->getPath(),
                $achieved_entry->getName()
            );
        }

        return $links;
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

    public function getPage(RfcCodexSection $section, $name): Page
    {
        $contents = $this->getContents($name);

        if ($contents === null) {
            // TODO
            $contents = "This should be a 404 page.";
        }

        return new Page(
            'RFC Codex - ' . $name,
            createDefaultEditInfo(),
            $this->getContentLinks(),
            createPrevNextLinksFromContentLinks($this->getContentLinks(), $name),
            $contents,
            new CopyrightInfo('Danack', 'https://github.com/Danack/RfcCodex/blob/master/LICENSE'),
            $breadcrumbs = new Breadcrumbs(new Breadcrumb($name, $name)),
            $section
        );
    }

    public function getIndexPage(RfcCodexSection $section): Page
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
            createDefaultEditInfo(),
            $this->getContentLinks(),
            new PrevNextLinks(null, null),
            $contents,
            new CopyrightInfo('Danack', 'https://github.com/Danack/RfcCodex/blob/master/LICENSE'),
            $breadcrumbs = new Breadcrumbs(),
            $section
        );
    }
}
