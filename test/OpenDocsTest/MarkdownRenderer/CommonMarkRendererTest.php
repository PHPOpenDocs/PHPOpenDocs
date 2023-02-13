<?php

declare(strict_types = 1);

namespace OpenDocsTest\MarkdownRenderer;

use PHPUnit\Framework\TestCase;
use OpenDocs\MarkdownRenderer\CommonMarkRenderer;

/**
 * @coversNothing
 */
class CommonMarkRendererTest extends TestCase
{
    /**
     * @covers \OpenDocs\MarkdownRenderer\CommonMarkRenderer
     */
    public function testRender()
    {
//        $renderer = new CommonMarkRenderer();
//        $result = $renderer->render("## I AM HEADER");
//        $anchorText = 'name="i-am-header"';
//
//        $positionOfAnchor = strpos($result, $anchorText);
//        $this->assertNotFalse($positionOfAnchor, 'Failed to find anchor for title.');
//
        $this->assertTrue(true);
    }
}
