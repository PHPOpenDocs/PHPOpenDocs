<?php

declare(strict_types = 1);

namespace RfcCodexOpenDocs;


use OpenDocs\ContentLinks;
use OpenDocs\FooterInfo;
use OpenDocs\Page;
use OpenDocs\PrevNextLinks;
use OpenDocs\URL;
use OpenDocs\ContentLinkLevel1;
use OpenDocs\ContentLinkLevel2;
use OpenDocs\MarkdownRenderer;


class RfcCodex {

    private MarkdownRenderer $markdownRenderer;

    /**
     * @var RfcCodexEntry[]
     */
    private array $under_discussion_entries = [];

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
    }

//    private array $done = [
//        //Annotations
////Briefer closure syntax
////Co- and contra-variance
////Named params
////Null short-circuiting - https://wiki.php.net/rfc/nullsafe_operator
////Union types
//    ];



    public function getContentLinks(): ContentLinks
    {
        $underDiscussionList = [];

        foreach ($this->under_discussion_entries as $entry) {
            $underDiscussionList[] = new ContentLinkLevel2(
                $entry->getPath(),
                $entry->getName(),
                null
            );
        }

        $underDiscussion = new ContentLinkLevel1(
            null,
            'Under discussion',
            $underDiscussionList
        );

        return new ContentLinks([$underDiscussion]);
    }

    public function getPage($path): Page
    {
       $contents = 'Shamoan';

       foreach ($this->under_discussion_entries as $entry) {
           if ($path === $entry->getPath()) {
               $fullPath = __DIR__ . "/../../vendor/danack/rfc-codex/" . $entry->getFilename();
               $markdown = file_get_contents($fullPath);
               $contents = $this->markdownRenderer->render($markdown);
          };
       }

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


