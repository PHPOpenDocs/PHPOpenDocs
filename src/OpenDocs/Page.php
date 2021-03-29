<?php

declare(strict_types = 1);

namespace OpenDocs;

class Page
{
    // The title for SEO
    private string $title;

    private EditInfo $editInfo;

    private array $contentLinks;

    private PrevNextLinks $prevNextLinks;

    private string $contentHtml;

    private CopyrightInfo $copyrightInfo;

    private Breadcrumbs $breadcrumbs;

    /**
     * Page constructor.
     * @param string $title
     * @param EditInfo $editInfo
     * @param ContentLink[] $contentLinks
     * @param PrevNextLinks $prevNextLinks
     * @param string $contentHtml
     * @param CopyrightInfo $copyrightOwner
     * @param Breadcrumbs $breadcrumbs
     */
    public function __construct(
        string $title,
        EditInfo $editInfo,
        array $contentLinks,
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

    public static function createFromHtml(
        string $title,
        string $contentHtml
    ): Page {
        $page = new \OpenDocs\Page(
            $title,
            createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
            [],
            new PrevNextLinks(null, null),
            $contentHtml,
            createDefaultCopyrightInfo(),
            new Breadcrumbs()
        );

        return $page;
    }

    public static function createFromHtmlEx(
        string $title,
        string $contentHtml,
        EditInfo $editInfo,
        \OpenDocs\Breadcrumbs $breadcrumbs
    ): Page {
        $page = new \OpenDocs\Page(
            $title,
            $editInfo,
            [],
            new PrevNextLinks(null, null),
            $contentHtml,
            createDefaultCopyrightInfo(),
            $breadcrumbs
        );

        return $page;
    }

    public static function createFromHtmlEx2(
        string $title,
        string $contentHtml,
        EditInfo $editInfo,
        \OpenDocs\Breadcrumbs $breadcrumbs,
        CopyrightInfo $copyrightInfo,
        \OpenDocs\LinkInfo $linkInfo
    ): Page {
        $page = new \OpenDocs\Page(
            $title,
            $editInfo,
            $linkInfo->getContentLinks(),
            $linkInfo->getPrevNextLinks(),
            $contentHtml,
            $copyrightInfo,
            $breadcrumbs
        );

        return $page;
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
     * @return ContentLink[]
     */
    public function getContentLinks(): array
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
