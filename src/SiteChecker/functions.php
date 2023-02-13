<?php

declare(strict_types = 1);

namespace SiteChecker;

use FluentDOM;

/**
 * @param string $html
 * @return Link[]
 */
function extract_links_from_html(string $html)
{
    $document = FluentDOM::load(
        $html,
        'text/html',
        [FluentDOM\Loader\Options::IS_STRING => true]
    );

    $links = [];

    foreach ($document('//a[@href]') as $a) {
        $links[] = new Link((string)$a, $a['href']);
    }

    return $links;
}
