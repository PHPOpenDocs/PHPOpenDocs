<?php

declare(strict_types = 1);

namespace PHPFunding;

use OpenDocs\Breadcrumbs;
use OpenDocs\MarkdownRenderer\MarkdownRenderer;
use OpenDocs\Page;
use OpenDocs\PrevNextLinks;
use OpenDocs\Section;

use function PHPFunding\createEditInfo;

class Pages
{
    private MarkdownRenderer $markdownRenderer;

    public function __construct(MarkdownRenderer $markdownRenderer)
    {
        $this->markdownRenderer = $markdownRenderer;
    }

    public function renderPhpFunding(PeopleList $peopleList, $version)
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

            if ($version === '8_0') {
                $workItems = $person->getWorkItems_8_0();
            }
            else if ($version === '8_1') {
                $workItems = $person->getWorkItems_8_1();
            }
            else {
                throw new \Exception("Unknown version string [$version]. Either 8_0 or 8_1 are known.");
            }


            if (count($workItems) === 0) {
                continue;
            }

            foreach ($workItems as $workItem) {
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

<br/>
<br/>

HTML;

        return $html;
    }


    public function renderExtensionsFunding(ExtensionList $extensionList)
    {
        $sponsorLinkFn = function (SponsorLink $sponsorLink) {
            $linkTemplate = "<a href=':attr_url'>:html_name</a>";

            $params = [
                ':attr_url' => $sponsorLink->getUrl(),
                ':html_name' => $sponsorLink->getName(),
            ];

            return esprintf($linkTemplate, $params);
        };

        $maintainerFn = function (Maintainer $maintainer) use ($sponsorLinkFn) {
            $sponsorLinks = array_map($sponsorLinkFn, $maintainer->getSponsorLinks());

            $linkTemplate = "<tr><td>:html_name</td><td>:raw_sponsor_links</td></tr>";
            $params = [
                ':html_name' => $maintainer->getName(),
                ':raw_sponsor_links' => implode(", ", $sponsorLinks)
            ];

            return esprintf($linkTemplate, $params);
        };

        $extensionFn = function (PHPExtension $phpExtension) use ($maintainerFn) {
            $maintainersHtmlArray = array_map($maintainerFn, $phpExtension->getMaintainers());

            $linkTemplate = <<< HTML
<h2>:html_name</h2>
<table class="funding_extensions">
    <tbody>:raw_maintiner_info</tbody>
</table>
HTML;

            $params = [
                ':html_name' => $phpExtension->getName(),
                ":attr_nuber_of_maintainers" => count($phpExtension->getMaintainers()),
                ':raw_maintiner_info' => implode("", $maintainersHtmlArray)
            ];

            return esprintf($linkTemplate, $params);
        };

        $rows = array_map($extensionFn, $extensionList->getExtensions());

        $extensionsInfo = implode("", $rows);

        $html = <<< HTML

<h1>Extensions</h1>

<p>
The PHP extensions are C libraries that are (mostly) maintained separately from PHP core.
</p>

$extensionsInfo

<br/>
<br/>

HTML;

        return $html;
    }

    public function renderUserlandFunding()
    {
        return "<b>Sha-mone userland.</b>";
    }

    public function getInternalsPage(Section $section, PeopleList $peopleList): Page
    {
        $contents = <<< HTML
<p>
    This is the list of RFCs that were passed for PHP 8, the authors involved with them, and links to their sponsors page.
</p>
HTML;

        $contents .= "<h2>PHP 8.1</h2>";
        $contents .= $this->renderPhpFunding($peopleList, "8_1");

        $contents .= "<h2>PHP 8.0</h2>";
        $contents .= $this->renderPhpFunding($peopleList, "8_0");

        $editInfo = createEditInfo('Edit page', __FILE__, __LINE__);
        $editInfo->addEditInfo(createEditInfo("Edit people list", __DIR__ . '/PeopleList.php', 20));

        return new Page(
            'Sponsoring PHP Internals',
            $editInfo,
            getFundingContentLinks(),
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
            createEditInfo('Edit page', __FILE__, __LINE__),
            getFundingContentLinks(),
            new PrevNextLinks(null, null),
            $contents,
            createDefaultCopyrightInfo(),
            Breadcrumbs::fromArray(["/userland" => "Userland"]),
            $section
        );
    }

    public function getExtensionPage(Section $section, ExtensionList $extensionList): Page
    {
        $contents = $this->renderExtensionsFunding($extensionList);

        $editInfo = createEditInfo('Edit page', __FILE__, __LINE__);
        $listEditInfo = createEditInfo('Edit list', __DIR__ . "src/PHPFunding/ExtensionList.php", 24);
        $editInfo->addEditInfo($listEditInfo);

        return new Page(
            'Sponsoring extensions',
            $editInfo,
            getFundingContentLinks(),
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
                ":attr_extensions_link" => $section->getPrefix() . '/extensions',
                ":attr_userland_link" => $section->getPrefix() . '/userland',
            ]
        );

        return new Page(
            'Sponsoring PHP',
            createEditInfo('Edit page', __FILE__, __LINE__ - 33),
            getFundingContentLinks(),
            new PrevNextLinks(null, null),
            $contents,
            createDefaultCopyrightInfo(),
            new Breadcrumbs(),
            $section
        );
    }
}
