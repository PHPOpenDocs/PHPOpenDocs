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

    public function provides_createPrevNextLinksFromContentLinks()
    {
        yield ['/mailing_list', '/rfc_attitudes'];
//        yield ['/rfc_etiquette', '/php_parameter_parsing'];
    }

    /**
     * @param $currentPosition
     * @param $expectedNextPosition
     * @dataProvider provides_createPrevNextLinksFromContentLinks
     */
    public function test_createPrevNextLinksFromContentLinks($currentPosition, $expectedNextPosition)
    {
        $contentLinks = getTestContentLinks();

        $prevNext = createPrevNextLinksFromContentLinks($contentLinks, $currentPosition);
        $nextLink = $prevNext->getNextLink();
        $this->assertInstanceOf(ContentLink::class, $nextLink);

        $this->assertSame($expectedNextPosition, $nextLink->getPath());
    }
}
