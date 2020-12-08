<?php

/**
 * This file holds functions for rendering the site html from components
 */

declare(strict_types = 1);

use OpenDocs\Breadcrumb;
use OpenDocs\Breadcrumbs;
use OpenDocs\PrevNextLinks;
use OpenDocs\ContentLinks;
use OpenDocs\ContentLinkLevel1;
use OpenDocs\ContentLinkLevel2;
use OpenDocs\ContentLinkLevel3;

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

    return esprintf($template, $params);
}

function createPageHeaderHtml() : string
{
    $html = <<< HTML
    <ul>
      <li><a href="/foo">Downloads</a></li>
      <li><a href="/bar">Documentation</a></li>
      <li><a href="/about">About</a></li>
    </ul>
HTML;

    return $html;
}


function createContentLinkLevel3Html(ContentLinkLevel3 $contentLinkLevel3): string
{
    $template = '<li><a href=":attr_path">:html_description</a></li>';
    $params = [
        ':html_description' => $contentLinkLevel3->getDescription(),
        ':attr_path' => $contentLinkLevel3->getPath(),
    ];

    return esprintf($template, $params);
}

function createContentLinkLevel2Html(ContentLinkLevel2 $contentLinkLevel2): string
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
                ':attr_path' => $contentLinkLevel2->getPath(),
            ]
        );
    }

    $children = $contentLinkLevel2->getChildren();

    if ($children === null) {
        return $html;
    }

    $li_elements = [];
    foreach ($children as $child) {
        $li_elements[] = createContentLinkLevel3Html($child);
    }

    return "<li>" . $html . "<ul class='opendocs_content_links_level_3'>". implode("\n", $li_elements) . "</ul></li>";
}

function createContentLinkLevel1Html(ContentLinkLevel1 $contentLinkLevel1): string
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
                ':attr_path' => $contentLinkLevel1->getPath(),
            ]
        );
    }

    $li_elements = [];
    foreach ($contentLinkLevel1->getChildren() as $contentLinkLevel2) {
        $li_elements[] = createContentLinkLevel2Html($contentLinkLevel2);
    }

    $html .= "<ul class='opendocs_content_links_level_2'>\n" . implode("\n", $li_elements) . "</ul>";

    return "<li>" . $html . "</li>";
}

function createContentLinksHtml(ContentLinks $contentLinks): string
{
    $li_elements = [];
    foreach ($contentLinks->getChildren() as $contentLinkLevel1) {
        $li_elements[] = createContentLinkLevel1Html($contentLinkLevel1);
    }

    return "<ul class='opendocs_content_links_level_1'>\n" . implode("\n", $li_elements) . "</ul>";
}
