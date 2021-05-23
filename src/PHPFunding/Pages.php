<?php

declare(strict_types = 1);

namespace PHPFunding;

use OpenDocs\Breadcrumbs;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\Page;
use OpenDocs\PrevNextLinks;
use OpenDocs\Section;

class Pages
{

    private MarkdownRenderer $markdownRenderer;

    public function __construct(MarkdownRenderer $markdownRenderer)
    {
        $this->markdownRenderer = $markdownRenderer;
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


    public function renderExtensionsFunding()
    {
        return "<b>Sha-mone extensions.</b>";
    }

    public function renderUserlandFunding()
    {
        return "<b>Sha-mone userland.</b>";
    }

    public function getInternalsPage(Section $section, PeopleList $peopleList): Page
    {
        $contents = $this->renderPhp8_0_funding($peopleList);

        return new Page(
            'Sponsoring PHP Internals',
            createDefaultEditInfo(),
            [],
            new PrevNextLinks(null, null),
            $contents,
            createDefaultCopyrightInfo(),
            Breadcrumbs::fromArray(["/internals" => "PHP Internals"]),
            $section
        );
    }

    public function getUserlandPage(Section $section): Page
    {
        $contents = $this->renderUserlandFunding();

        return new Page(
            'Sponsoring Userland',
            createDefaultEditInfo(),
            [],
            new PrevNextLinks(null, null),
            $contents,
            createDefaultCopyrightInfo(),
            Breadcrumbs::fromArray(["/userland" => "Userland"]),
            $section
        );
    }

    public function getExtensionPage(Section $section): Page
    {
        $contents = $this->renderExtensionsFunding();

        return new Page(
            'Sponsoring extensions',
            createDefaultEditInfo(),
            [],
            new PrevNextLinks(null, null),
            $contents,
            createDefaultCopyrightInfo(),
            Breadcrumbs::fromArray(["/extensions" => "Extensions"]),
            $section
        );
    }


    public function getIndexPage(Section $section, PeopleList $peopleList): Page
    {
        $contents = <<< HTML

<p>
  Open Source development needs to be sustainable.
</p>

<p>Without adequate funding in place, there are many maintainence tasks that are either too boring, or too difficult to done on a volunteer basis. If you have a business that relies on using Open Source projects, you should either sponsor them, or prepare yourself to not be suprised when the project withers and dies.</p>

<p>The sponsoring links are broken up into three sections:</p>


<ul>
  <li><a href=":attr_internals_link">Internals</a> - aka the core PHP maintainers who look after the actual language.</li>
  <li><a href=":attr_extensions_link">Extensions</a> - aka the C extensions that are installed separately from PHP e.g. xdebug, Imagick.</li>
  <li><a href=":attr_userland_link">Userland</a> - these are libraries written in PHP that you probably install through Composer.</li>
</ul>


HTML;

        $contents = esprintf(
            $contents,
            [
                ":attr_internals_link" => $section->getPrefix() . '/internals',
                ":attr_extensions_link" => $section->getPrefix() . '/userland',
                ":attr_userland_link" => $section->getPrefix() . '/extensions',
            ]
        );

        return new Page(
            'Sponsoring PHP',
            createDefaultEditInfo(),
            [],
            new PrevNextLinks(null, null),
            $contents,
            createDefaultCopyrightInfo(),
            new Breadcrumbs(),
            $section
        );
    }
}
