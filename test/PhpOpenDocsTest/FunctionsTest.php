<?php

declare(strict_types = 1);

namespace PHPOpenDocsTest;

//use OpenDocs\ContentLinks;
use OpenDocs\ContentLink;

/**
 * @coversNothing
 * @group wip
 */
class FunctionsTest extends BaseTestCase
{

//    public function provides_createPrevNextLinksFromContentLinks()
//    {
//        yield ['/mailing_list', '/rfc_attitudes'];
////        yield ['/rfc_etiquette', '/php_parameter_parsing'];
//    }
//
//    /**
//     * @param $currentPosition
//     * @param $expectedNextPosition
//     * @dataProvider provides_createPrevNextLinksFromContentLinks
//     */
//    public function test_createPrevNextLinksFromContentLinks($currentPosition, $expectedNextPosition)
//    {
//        $contentLinks = getTestContentLinks();
//
//        $prevNext = createPrevNextLinksFromContentLinks($contentLinks, $currentPosition);
//        $nextLink = $prevNext->getNextLink();
//        $this->assertInstanceOf(ContentLink::class, $nextLink);
//
//        $this->assertSame($expectedNextPosition, $nextLink->getPath());
//    }


    public function test_replace_local_links()
    {
        $markdown_input = <<< MD
Ohohohoho
[This is a link](/link)
indeed
[Get involved](https://www.php.net/get-involved) - Help make PHP better!
MD;

        $markdown_expected = <<< MD
Ohohohoho
[This is a link](https://www.google.com/link)
indeed
[Get involved](https://www.php.net/get-involved) - Help make PHP better!
MD;

        $result = replace_local_links($markdown_input, 'https://www.google.com');

        $this->assertSame($markdown_expected, $result);
    }
}
