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

class UrlStatus
{
    private $status = 0;

    private string|null $error_message = null;

    public function __construct(
        private string $url,
        private string $origin_url
    ) {

    }

    public function setStatus(int $new_status)
    {
        $this->status = $new_status;
    }

    public function setError(int $status_code, string $error_message)
    {
        $this->status = $status_code;
        $this->error_message = $error_message;
    }

    public function setOk()
    {
        $this->status = 200;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getOriginUrl(): string
    {
        return $this->origin_url;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->error_message;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }


}


class SiteChecker
{
    /**
     * @var UrlStatus[]
     */
    private $urls = [];

    /**
     * @var string[]
     */
    private array $excluded_urls;

    public function __construct(private string $base_domain, string $initial_url, array $excluded_urls)
    {
        $this->urls[$initial_url] = new UrlStatus($initial_url, $initial_url);
        $this->excluded_urls = $excluded_urls;
    }

    public function run()
    {
        do {
            foreach ($this->urls as $url => $urlStatus) {
                if ($urlStatus->getStatus() !== 0) {
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

        $this->urls[$url]->setStatus(1);

        [$statusCode, $body, $headers] = fetchUri($full_url, 'GET');

        if ($statusCode !== 200) {
//            $this->errors[] = "page $url is not 200 OK, but instead $statusCode";
            $this->urls[$url]->setError($statusCode, "page $url is not 200 OK, but instead $statusCode");
            return;
        }

        $this->urls[$url]->setOk();

        // Extract links.
        $links = extract_links_from_html($body);
//        echo "Found " . count($links) . " links at \n";

        $links_added = 0;

        foreach ($links as $link) {
            $new_url = $link->getHref();

            if (str_starts_with($new_url, '/') !== true) {
//                echo "Skipping external url $url \n";
                continue;
            }

            if (array_contains($new_url, $this->excluded_urls) === true) {
                continue;
            }

            if (array_key_exists($new_url, $this->urls) === false) {
                echo "Added url $url \n";
                $this->urls[$new_url] = new UrlStatus($new_url, $url);
                $links_added += 1;
            }
        }

        if ($links_added !== 0) {
            echo "Added $links_added links from $url \n";
        }

    }
    public function anyLeftToCheck()
    {
        foreach ($this->urls as $url => $urlStatus) {
            if ($urlStatus->getStatus() === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return UrlStatus[]
     */
    public function getErrors()
    {
        $errors = [];

        foreach ($this->urls as $url => $urlStatus) {
            $errorMessage = $urlStatus->getErrorMessage();
            if ($errorMessage !== null) {
                $errors[] = $urlStatus;
            }
        }

        return $errors;
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