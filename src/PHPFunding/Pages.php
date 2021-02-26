<?php

declare(strict_types = 1);

namespace PHPFunding;

use OpenDocs\Breadcrumbs;
use OpenDocs\ContentLinks;
use OpenDocs\FooterInfo;
use OpenDocs\Page;
use OpenDocs\Section;
use OpenDocs\PrevNextLinks;
use OpenDocs\URL;
use OpenDocs\ContentLinkLevel1;
use OpenDocs\ContentLinkLevel2;
use OpenDocs\MarkdownRenderer;
use PHPFunding\PeopleList;
use RfcCodexOpenDocs\RfcCodexEntry;
use PHPFunding\Rfc;

class Pages
{

    private MarkdownRenderer $markdownRenderer;

    public function __construct(MarkdownRenderer $markdownRenderer)
    {
        $this->markdownRenderer = $markdownRenderer;
    }

    public function getContentLinks(): ContentLinks
    {
//        $underDiscussion = $this->makeList(
//            'Under discussion',
//            $this->under_discussion_entries
//        );

//        $achieved = $this->makeList(
//            'Ideas that overcame their challenges',
//            $this->achieved_entries
//        );


        return new ContentLinks([]);
    }

    public function renderPhp8_0_funding(PeopleList $peopleList)
    {
        $rows = [];

        $workItemsTemplate = "<a href=':attr_link'>:html_description</a>";

        $personRowTemplate = <<< HTML
<tr>
  <td>:html_name</td>
  <td>:raw_sponsor_links</td>
  <td>:raw_workitems</td>
</tr>
HTML;

        foreach ($peopleList->getPeople() as $person) {
            $workItemsList = [];
            foreach ($person->getWorkItems() as $workItem) {
                $params = [
                    ':attr_link' => $workItem->getUrl(),
                    ':html_description' => $workItem->getDescription()
                ];
                $workItemsList[] = esprintf($workItemsTemplate, $params);
            }

            $sponsorLink = '';
            if (($link = $person->getGithubSponsor()) !== null) {
                $sponsorLink = esprintf("<a href=':attr_link'>Github</a>", [':attr_link' => $link]);
            }

            $personParams = [
                ':html_name' => $person->getName(),
                ':raw_sponsor_links' => $sponsorLink,
                ':raw_workitems' => implode("<br/>", $workItemsList)
            ];
            $rows[] = esprintf($personRowTemplate, $personParams);
        }

        $rowString = implode("", $rows);

        $html = <<< HTML

<p>
This is the list of RFCs that were passed for PHP 8, the authors involved with them, and links to their sponsors page.
<b>TODO</b> still need to add the declined RFCs.
</p>

<table>
  <thead>
    <tr>
     <th>Person</th>
     <th>Sponsor links</th>
     <th>Work items</th> 
    </tr>
  </thead>
  <tbody>$rowString</tbody>
</table>

HTML;

        return $html;
    }

    public function getIndexPage(Section $section, PeopleList $peopleList): Page
    {

        $contents = $this->renderPhp8_0_funding($peopleList);

        return new Page(
            'Rfc Codex',
            createDefaultEditInfo(),
            $this->getContentLinks(),
            new PrevNextLinks(null, null),
            $contents,
            createDefaultCopyrightInfo(),
            new Breadcrumbs()
        );
    }
}
