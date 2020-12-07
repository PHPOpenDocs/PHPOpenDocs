<?php

declare(strict_types = 1);

namespace OpenDocs;

class Page
{
    private ?Link $next;

    private ?Link $previous;

    /** @var NavigationLink[] */
    private array $navigationLinks;

    // The title for SEO
    private string $title;

    private URL $editUrl;

    private URL $reportBugUrl;

    // The HTML content of the page.
    private string $content;

    /**
     *
     * @param Link|null $next
     * @param Link|null $previous
     * @param NavigationLink[] $navigationLinks
     * @param string $title
     * @param URL $editUrl
     * @param URL $reportBugUrl
     * @param string $content
     */
    public function __construct(
        ?Link $next,
        ?Link $previous,
        array $navigationLinks,
        string $title,
        URL $editUrl,
        URL $reportBugUrl,
        string $content
    ) {
        $this->next = $next;
        $this->previous = $previous;
        $this->navigationLinks = $navigationLinks;
        $this->title = $title;
        $this->editUrl = $editUrl;
        $this->reportBugUrl = $reportBugUrl;
        $this->content = $content;
    }

    /**
     * @return Link|null
     */
    public function getNext(): ?Link
    {
        return $this->next;
    }

    /**
     * @return Link|null
     */
    public function getPrevious(): ?Link
    {
        return $this->previous;
    }

    /**
     * @return NavigationLink
     */
    public function getNavigationLinks(): NavigationLink
    {
        return $this->navigationLinks;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return URL
     */
    public function getEditUrl(): URL
    {
        return $this->editUrl;
    }

    /**
     * @return URL
     */
    public function getReportBugUrl(): URL
    {
        return $this->reportBugUrl;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
