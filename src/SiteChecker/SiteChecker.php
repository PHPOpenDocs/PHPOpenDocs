<?php

declare(strict_types = 1);

namespace SiteChecker;

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

    public function run(): void
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

    private function checkUrl(string $url): void
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

    public function anyLeftToCheck(): bool
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

    public function numberOfPagesChecked(): int
    {
        return count($this->urls);
    }

    public function dumpPagesChecked(): void
    {
        $urls = array_keys($this->urls);

        sort($urls);

        foreach ($urls as $url) {
            echo "$url\n";
        }
    }
}
