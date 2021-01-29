<?php

/**
 * This file holds functions for rendering the site html from components
 */

declare(strict_types = 1);

use OpenDocs\Breadcrumbs;
use OpenDocs\PrevNextLinks;
use OpenDocs\ContentLinks;
use OpenDocs\ContentLinkLevel1;
use OpenDocs\ContentLinkLevel2;
use OpenDocs\ContentLinkLevel3;
use OpenDocs\FooterInfo;
use OpenDocs\Page;
use OpenDocs\URL;
use OpenDocs\HeaderLink;
use OpenDocs\HeaderLinks;
use OpenDocs\CopyrightInfo;
use OpenDocs\EditInfo;

function fooasdoiasdoi(string $path, string $description)
{
    $li_template = "<li><a href=':attr_link'>:html_description</a></li>";
    $params = [
        ':attr_link' => $path,
        ':html_description' => $description
    ];
    return esprintf($li_template, $params);
}

function createBreadcrumbHtml(
    ?\OpenDocs\Section $section,
    Breadcrumbs $breadcrumbs
): string {

    $prefix = '';
    $li_parts = [];

    if ($section !== null) {
        $prefix  = $section->getPrefix();
        $li_parts[] = fooasdoiasdoi($prefix, $section->getName());
    }

    foreach ($breadcrumbs->getBreadcrumbs() as $breadcrumb) {
        $li_parts[] = fooasdoiasdoi(
            $prefix . $breadcrumb->getPath(),
            $breadcrumb->getDescription()
        );
    }

    if (count($li_parts) === 0) {
        return "";
    }


    return "<ul>" . implode("", $li_parts) . "</ul>";
}

function createPrevNextHtml(?PrevNextLinks $prevNextLinks): string
{
    if ($prevNextLinks === null) {
        return "";
    }

    $prevLink = $prevNextLinks->getPrevLink();
    $nextLink = $prevNextLinks->getNextLink();

    $template = '';
    $params = [];

    if ($prevLink) {
        $template .= '<span class="opendocs_prev"><a href=":attr_prev_link">«&nbsp;:html_prev_description</a></span>';
        $params[':attr_prev_link'] = $prevLink->getPath();
        $params[':html_prev_description'] = $prevLink->getDescription();
    }

    if ($nextLink) {
        $template .= '<span class="opendocs_next"><a href=":attr_next_link">:html_next_description&nbsp;»</a></span>';
        $params[':attr_next_link'] = $nextLink->getPath();
        $params[':html_next_description'] = $nextLink->getDescription();
    }

    return "<span class='opendocs_prev_next_container'>" . esprintf($template, $params) ."</span>";
}

function createPageHeaderHtml(HeaderLinks $headerLinks) : string
{

    $template = '<li><a href=":attr_path">:html_description</a></li>';
    $html = "<ul>";

    foreach ($headerLinks->getHeaderLinks() as $headerLink) {
        $params = [
            ':html_description' => $headerLink->getDescription(),
            ':attr_path' => $headerLink->getPath(),
        ];
        $html .= esprintf($template, $params);
    }

    $html .= "<ul>";

    return $html;
}


function createStandardHeaderLinks(): HeaderLinks
{
    return new HeaderLinks([
        new HeaderLink("/", "Home"),
        new HeaderLink("/sections", "Sections"),
        new HeaderLink("/about", "About"),
    ]);
}


function createContentLinkLevel3Html(string $sectionPath, ContentLinkLevel3 $contentLinkLevel3): string
{
    $template = '<li><a href=":attr_path">:html_description</a></li>';
    $params = [
        ':html_description' => $contentLinkLevel3->getDescription(),
        ':attr_path' => $sectionPath . $contentLinkLevel3->getPath(),
    ];

    return esprintf($template, $params);
}

function getUrl($sectionPath, $path)
{
    // It's an external url
    if (strpos($path, 'http') === 0) {
        return $path;
    }

    return $sectionPath . $path;
}

function createContentLinkLevel2Html(string $sectionPath, ContentLinkLevel2 $contentLinkLevel2): string
{
    $path = $contentLinkLevel2->getPath();
    if ($path === null) {
        $html = esprintf(
            "<span>:html_description</span>",
            [':html_description' => $contentLinkLevel2->getDescription()]
        );
    }
    else {
        $html = esprintf(
            '<a href=":attr_path">:html_description</a></span>',
            [
                ':html_description' => $contentLinkLevel2->getDescription(),
                ':attr_path' => getUrl($sectionPath, $contentLinkLevel2->getPath()),
            ]
        );
    }

    $children = $contentLinkLevel2->getChildren();

    if ($children === null) {
        return $html;
    }

    $li_elements = [];
    foreach ($children as $child) {
        $li_elements[] = createContentLinkLevel3Html($sectionPath, $child);
    }

    return "<li>" . $html . "<ul class='opendocs_content_links_level_3'>". implode("\n", $li_elements) . "</ul></li>";
}

function createContentLinkLevel1Html(string $sectionPath, ContentLinkLevel1 $contentLinkLevel1): string
{
    $path = $contentLinkLevel1->getPath();
    if ($path === null) {
        $html = esprintf(
            "<div>:html_description</div>",
            [':html_description' => $contentLinkLevel1->getDescription()]
        );
    }
    else {
        $html = esprintf(
            '<a href=":attr_path">:html_description</a>',
            [
                ':html_description' => $contentLinkLevel1->getDescription(),
                ':attr_path' => $sectionPath . $contentLinkLevel1->getPath(),
            ]
        );
    }

    $li_elements = [];
    $children = $contentLinkLevel1->getChildren();
    if ($children !== null) {
        foreach ($children as $contentLinkLevel2) {
            $li_elements[] = createContentLinkLevel2Html($sectionPath, $contentLinkLevel2);
        }

        $html .= "<ul class='opendocs_content_links_level_2'>\n" . implode("\n", $li_elements) . "</ul>";
    }

    return "<li>" . $html . "</li>";
}

function createContentLinksHtml(string $sectionPath, ContentLinks $contentLinks): string
{
    $li_elements = [];
    $children = $contentLinks->getChildren();

    if ($children === null) {
        return "";
    }

    foreach ($children as $contentLinkLevel1) {
        $li_elements[] = createContentLinkLevel1Html($sectionPath, $contentLinkLevel1);
    }

    return "<ul class='opendocs_content_links_level_1'>\n" . implode("\n", $li_elements) . "</ul>";
}


/**
 * @param array<string, string> $namesWithLinks
 */
function createEditLinks(array $namesWithLinks): string
{
    $html_snippets = [];

    $template = '<a href=":attr_edit_link">:html_description</a>';

    foreach ($namesWithLinks as $name => $link) {
        $html_snippets[] = esprintf(
            $template,
            [':html_description' => $name, ":attr_edit_link" => $link]
        );
    }

    return implode($html_snippets);
}

function createFooterHtml(
    CopyrightInfo $copyrightInfo,
    EditInfo $editInfo
): string {
    $html = <<< HTML
<span class="copyright">
  <a href=":attr_copyright_link">© :html_copyright_name</a>
</span>
<span class="edit_link">
  :raw_edit_links
</span>
HTML;


    $params = [
        ':html_copyright_name' => $copyrightInfo->getName(),
        ':attr_copyright_link' => $copyrightInfo->getLink(),
        ':raw_edit_links' => createEditLinks($editInfo->getNamesWithLinks())
    ];

    return esprintf($html, $params);
}


function createPageHtml(
    ?\OpenDocs\Section $section,
    Page $page,
    Breadcrumbs $breadcrumbs
): string {

    $headerLinks = createStandardHeaderLinks();

    $prefix = '/';
    if ($section) {
        $prefix = $section->getPrefix();
    }

    $pageTitle = $page->getTitle() ?? "PHP OpenDocs";

    $params = [
        ':raw_site_css_link' => '/css/site.css?time=' . time(),
        ':html_page_title' => $pageTitle,
        ':raw_top_header' => createPageHeaderHtml($headerLinks),
        ':raw_breadcrumbs' => createBreadcrumbHtml($section, $page->getBreadcrumbs()),
        ':raw_prev_next' => createPrevNextHtml($page->getPrevNextLinks()),
        ':raw_content' => $page->getContentHtml(),
        ':raw_nav_content' => createContentLinksHtml($prefix, $page->getContentLinks()),
        ':raw_footer' => createFooterHtml($page->getCopyrightInfo(), $page->getEditInfo()),
    ];

    $html = file_get_contents(__DIR__ . "/../templates/standard_page.html");

    return esprintf($html, $params);
}
