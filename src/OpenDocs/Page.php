<?php

declare(strict_types = 1);

namespace OpenDocs;

class Page
{
    // The title for SEO
    private string $title;

    private EditInfo $editInfo;

    private ContentLinks $contentLinks;

    private PrevNextLinks $prevNextLinks;

    private string $contentHtml;

    private CopyrightInfo $copyrightInfo;

    private Breadcrumbs $breadcrumbs;

    public function __construct(
        string $title,
        EditInfo $editInfo,
        ContentLinks $contentLinks,
        PrevNextLinks $prevNextLinks,
        string $contentHtml,
        CopyrightInfo $copyrightOwner,
        Breadcrumbs $breadcrumbs
    ) {
        $this->title = $title;
        $this->editInfo = $editInfo;
        $this->contentLinks = $contentLinks;
        $this->prevNextLinks = $prevNextLinks;
        $this->contentHtml = $contentHtml;
        $this->copyrightInfo = $copyrightOwner;
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return EditInfo
     */
    public function getEditInfo(): EditInfo
    {
        return $this->editInfo;
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

    public function getCopyrightInfo(): CopyrightInfo
    {
        return $this->copyrightInfo;
    }

    /**
     * @return Breadcrumbs
     */
    public function getBreadcrumbs(): Breadcrumbs
    {
        return $this->breadcrumbs;
    }
}
