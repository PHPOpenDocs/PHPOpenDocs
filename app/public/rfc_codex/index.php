<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\Page;
use RfcCodexOpenDocs\RfcCodexEntry;
use RfcCodexOpenDocs\RfcCodexSection;
use function RfcCodexOpenDocs\getUnderDiscussionList;
use function RfcCodexOpenDocs\getAchievedList;
use function RfcCodexOpenDocs\createGlobalPageInfoForRfcCodex;

/**
 * @param RfcCodexEntry[] $links
 * @return string
 */
function getLinkList(RfcCodexSection $section, $links)
{
    $htmlLines = [];

    foreach ($links as $linkAndDescription) {
        $description = $linkAndDescription->getName();
        $link = $linkAndDescription->getPath();
        $htmlLines[] = sprintf(
            "<li><a href='%s/%s'>%s</a></li>",
            $section->getPrefix(),
            $link,
            $description
        );
    }

    return "<ul>" . implode("\n", $htmlLines) . "</ul>";
}




function getHtml(RfcCodexSection $section): string
{
    $under_discussion = getLinkList($section, getUnderDiscussionList());

    $achieved_html = getLinkList($section, getAchievedList());

    $html  = <<< HTML

<h1>RFC Codex</h1>
<p>
These are some notes on PHP RFCs, why some were declined, and what others might need for them to be implemented.
</p>
<p>
The purpose of these documents is to avoid information from being lost and to try to avoid conversations needing to be repeated multiple times on PHP internals.
</p>

<h2> Things still being discussed</h2>

$under_discussion

<h2>Ideas that overcame their challenges</h2>

<p>
  PHP is actually getting better. These are all things that used to be pipe-dreams, but are now in PHP core.
</p>

$achieved_html

<h2>Things that are probably moot</h2>

<p>
PHP is actually getting better, but that means that some solutions to problems have become pretty moot, as they seek to solve problems that are now less of a problem.
</p>

<a href="/rfc_codex/explicit_defaults">Explicit defaults</a>

<h2>Misc notes</h2>

<p>
Someone asked for a summary of the <a href="/rfc_codex/spl_summary">general issues with the PHP SPL
</a>.
</p>

HTML;

    return $html;
};


$fn = function (RfcCodexSection $section): Page
{
    createGlobalPageInfoForRfcCodex(
        title: 'RFC codex',
        html: getHtml($section)
    );

    return \OpenDocs\Page::createFromHtmlGlobalPageInfo();
};


showPageResponse($fn);