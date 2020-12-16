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

function createBreadcrumbHtml(Breadcrumbs $breadcrumbs): string
{
    if (count($breadcrumbs->getBreadcrumbs()) === 0) {
        return "";
    }

    $li_template = "<li><a href=':attr_link'>:html_description</a></li>";
    $li_parts = [];

    foreach ($breadcrumbs->getBreadcrumbs() as $breadcrumb) {
        $params = [
            // todo - needs to be relative to content base
            ':attr_link' => $breadcrumb->getPath(),
            ':html_description' => $breadcrumb->getDescription()
        ];

        $li_parts[] = esprintf($li_template, $params);
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
        $template .= '<span class="opendocs_prev"><a href=":attr_prev_link">« :html_prev_description</a></span>';
        $params[':attr_prev_link'] = $prevLink->getPath();
        $params[':html_prev_description'] = $prevLink->getDescription();
    }

    if ($nextLink) {
        $template .= '<span class="opendocs_next"><a href=":attr_next_link">:html_next_description  »</a></span>';
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
                ':attr_path' => $sectionPath . $contentLinkLevel2->getPath(),
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
            "<span>:html_description</span>",
            [':html_description' => $contentLinkLevel1->getDescription()]
        );
    }
    else {
        $html = esprintf(
            '<a href=":attr_path">:html_description</a></span>',
            [
                ':html_description' => $contentLinkLevel1->getDescription(),
                ':attr_path' => $sectionPath . $contentLinkLevel1->getPath(),
            ]
        );
    }

    $li_elements = [];
    foreach ($contentLinkLevel1->getChildren() as $contentLinkLevel2) {
        $li_elements[] = createContentLinkLevel2Html($sectionPath, $contentLinkLevel2);
    }

    $html .= "<ul class='opendocs_content_links_level_2'>\n" . implode("\n", $li_elements) . "</ul>";

    return "<li>" . $html . "</li>";
}

function createContentLinksHtml(string $sectionPath, ContentLinks $contentLinks): string
{
    $li_elements = [];
    foreach ($contentLinks->getChildren() as $contentLinkLevel1) {
        $li_elements[] = createContentLinkLevel1Html($sectionPath, $contentLinkLevel1);
    }

    return "<ul class='opendocs_content_links_level_1'>\n" . implode("\n", $li_elements) . "</ul>";
}


function createFooterHtml(string $copyrightOwner, URL $editUrl): string
{
    $html = <<< HTML
<span class="copyright">© :html_copyright_name</span>
<span class="edit_link">
  <a href=":attr_edit_link">Edit this page</a>
</span>
HTML;

    $params = [
        ':html_copyright_name' => $copyrightOwner,
        ':attr_edit_link' => $editUrl->getUrl()
    ];

    return esprintf($html, $params);
}


function createPageHtml(
    string $sectionPath,
    Page $page,
    Breadcrumbs $breadcrumbs
): string {

    $headerLinks = createStandardHeaderLinks();

    $params = [
        ':raw_top_header' => createPageHeaderHtml($headerLinks),
        ':raw_breadcrumbs' => createBreadcrumbHtml($breadcrumbs),
        ':raw_prev_next' => createPrevNextHtml($page->getPrevNextLinks()),
        ':raw_content' => $page->getContentHtml(),
        ':raw_nav_content' => createContentLinksHtml($sectionPath, $page->getContentLinks()),
        ':raw_footer' => createFooterHtml($page->getCopyrightOwner(), $page->getEditUrl()),
    ];

    $html = file_get_contents(__DIR__ . "/../templates/standard_page.html");

    return esprintf($html, $params);
}