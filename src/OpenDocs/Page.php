<?php

declare(strict_types = 1);

namespace OpenDocs;

class Page
{
    // The title for SEO
    private string $title;

    private URL $editUrl;

    private ContentLinks $contentLinks;

    private PrevNextLinks $prevNextLinks;

    private string $contentHtml;

    private string $copyrightOwner;

    /**
     *
     * @param string $title
     * @param URL $editUrl
     * @param ContentLinks $contentLinks
     * @param PrevNextLinks $prevNextLinks
     * @param string $contentHtml
     */
    public function __construct(
        string $title,
        URL $editUrl,
        ContentLinks $contentLinks,
        PrevNextLinks $prevNextLinks,
        string $contentHtml,
        string $copyrightOwner
    ) {
        $this->title = $title;
        $this->editUrl = $editUrl;
        $this->contentLinks = $contentLinks;
        $this->prevNextLinks = $prevNextLinks;
        $this->contentHtml = $contentHtml;
        $this->copyrightOwner = $copyrightOwner;
    }

    public static function errorPage($errorContentsHtml)
    {
        return new self(
            'error',
            new URL('www.example.com'),
            ContentLinks::createEmpty(),
            new PrevNextLinks(null, null),
            $contentHtml = $errorContentsHtml,
            $copyrightOwner = 'PHPImagick'
        );
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
     * @return ContentLinks
     */
    public function getContentLinks(): ContentLinks
    {
        return $this->contentLinks;
    }

    /**
     * @return PrevNextLinks
     */
    public function getPrevNextLinks(): PrevNextLinks
    {
        return $this->prevNextLinks;
    }

    /**
     * @return string
     */
    public function getContentHtml(): string
    {
        return $this->contentHtml;
    }

    /**
     * @return string
     */
    public function getCopyrightOwner(): string
    {
        return $this->copyrightOwner;
    }
}
