<?php

namespace SiteChecker;

use FluentDOM;

class Link
{
    public function __construct(private string $caption, private string $href)
    {
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }
}

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


//function check_links_contains_link($links, $name, $url): bool
//{
//    foreach ($links as $link) {
//        if ($link['caption'] === $name &&
//            $link['href'] === $url) {
//            return true;
//        }
//    }
//
//    return false;
//}


class SiteChecker
{
    private $urls = [];

    private $errors = [];


    public function __construct(private string $base_domain, string $initial_url)
    {
        $this->urls[$initial_url] = null;
    }

    public function run()
    {
        do {

            foreach ($this->urls as $url => $result) {
                if ($result !== null) {
                    continue;
                }

                $this->checkUrl($url);
            }

            $finished = true;
            if ($this->anyLeftToCheck() === true) {
                $finished = false;
            }
        }
        while ($finished === false);
    }

    private function checkUrl(string $url)
    {
        $full_url = $this->base_domain . $url;

        echo "Checking $full_url \n";

        $this->urls[$url] = "temp";

        [$statusCode, $body, $headers] = fetchUri($full_url, 'GET');

        if ($statusCode !== 200) {
            $this->errors[] = "page $url is not 200 OK, but instead $statusCode";
            $this->urls[$url] = "not ok";
            return;
        }

        $this->urls[$url] = "ok";

        // Extract links.
        $links = extract_links_from_html($body);
//        echo "Found " . count($links) . " links at \n";

        $links_added = 0;

        foreach ($links as $link) {
            $url = $link->getHref();

            if (str_starts_with($url, '/') !== true) {
//                echo "Skipping external url $url \n";
                continue;
            }

            if (array_key_exists($url, $this->urls) === false) {
                echo "Added url $url \n";
                $this->urls[$url] = null;
                $links_added += 1;
            }
        }

        if ($links_added !== 0) {
            echo "Added $links_added links from $url \n";
        }

    }
    public function anyLeftToCheck()
    {
        foreach ($this->urls as $url => $result) {
            if ($result === null) {
                return true;
            }
        }
        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function numberOfPagesChecked()
    {
        return count($this->urls);
    }

    public function dumpPagesChecked()
    {
        $urls = array_keys($this->urls);

        sort($urls);

        foreach ($urls as $url) {
            echo "$url\n";
        }
    }
}