<?php

declare(strict_types = 1);

require_once __DIR__ . "/../../../src/web_bootstrap.php";

use OpenDocs\Page;
use RfcCodexOpenDocs\RfcCodexEntry;
use RfcCodexOpenDocs\RfcCodexSection;
use function RfcCodexOpenDocs\showRfcCodexResponse;
use function RfcCodexOpenDocs\createRfcCodexDefaultCopyrightInfo;
use function RfcCodexOpenDocs\getRfcCodexContentLinks;
use function RfcCodexOpenDocs\getUnderDiscussionList;
use function RfcCodexOpenDocs\getAchievedList;

/**
 * @param RfcCodexEntry[] $links
 * @return string
 */
function getLinkList($links)
{
    $htmlLines = [];

    foreach ($links as $linkAndDescription) {
        $description = $linkAndDescription->getName();
        $link = $linkAndDescription->getPath();
        $htmlLines[] = sprintf(
            "<li><a href='%s'>%s</a></li>",
            $link,
            $description
        );
    }

    return "<ul>" . implode("\n", $htmlLines) . "</ul>";
}

$fn = function (
    RfcCodexSection $section,
    \OpenDocs\BreadcrumbsFactory $breadcrumbsFactory
) : Page {

    $under_discussion = getLinkList(getUnderDiscussionList());

    $achieved_html = getLinkList(getAchievedList());

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


<h2>TODO</h2>

<p>
These need to be summarised.
</p>

Async / fibres - this is being worked on.<br/>

Pipe-operator - https://wiki.php.net/rfc/pipe-operator<br/>

Tuple returns - though these would be moot if we had out parameters.<br/>

Type declarations type number = float | int; <br/>

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


    $page = Page::createFromHtmlEx2(
        'RFC Codex',
        $html,
        createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
        $breadcrumbsFactory->createFromArray([]),
        createRfcCodexDefaultCopyrightInfo(),
        createLinkInfo('/', getRfcCodexContentLinks()),
        $section
    );

    return $page;
};




showRfcCodexResponse($fn);