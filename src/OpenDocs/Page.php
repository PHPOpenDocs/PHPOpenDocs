<?php

declare(strict_types = 1);

namespace OpenDocs;

use OpenDocs\GlobalPageInfo;

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

    private ?Section $section;

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
        Breadcrumbs $breadcrumbs,
        ?Section $section
    ) {
        $this->title = $title;
        $this->editInfo = $editInfo;
        $this->contentLinks = $contentLinks;
        $this->prevNextLinks = $prevNextLinks;
        $this->contentHtml = $contentHtml;
        $this->copyrightInfo = $copyrightOwner;
        $this->breadcrumbs = $breadcrumbs;
        $this->section = $section;
    }

    public static function createFromHtml(
        string $title,
        string $contentHtml,
        ?Section $section
    ): Page {
        $page = new \OpenDocs\Page(
            $title,
            createPHPOpenDocsEditInfo('Edit page', __FILE__, null),
            [],
            new PrevNextLinks(null, null),
            $contentHtml,
            createDefaultCopyrightInfo(),
            new Breadcrumbs(),
            $section
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
            $breadcrumbs,
            null
        );

        return $page;
    }

    public static function createFromHtmlEx2(
        string $title,
        string $contentHtml,
        EditInfo $editInfo,
        \OpenDocs\Breadcrumbs $breadcrumbs,
        CopyrightInfo $copyrightInfo,
        \OpenDocs\LinkInfo $linkInfo,
        Section $section
    ): Page {
        $page = new \OpenDocs\Page(
            $title,
            $editInfo,
            $linkInfo->getContentLinks(),
            $linkInfo->getPrevNextLinks(),
            $contentHtml,
            $copyrightInfo,
            $breadcrumbs,
            $section
        );

        return $page;
    }


    public static function createFromHtmlGlobalPageInfo(): Page
    {
        $prefix = GlobalPageInfo::getSection()->getPrefix();
        $request_path = getRequestPath();

        if (str_starts_with($request_path, $prefix) === true) {
            $request_path = substr($request_path, strlen($prefix));
        }

        $linkInfo = createLinkInfo(
            $request_path,
            GlobalPageInfo::getContentLinks(),
        );

        $page = new \OpenDocs\Page(
            GlobalPageInfo::getTitle(),
            GlobalPageInfo::getEditInfo(),
            GlobalPageInfo::getContentLinks(),
            $linkInfo->getPrevNextLinks(),
            GlobalPageInfo::getContentHtml(),
            GlobalPageInfo::getCopyrightInfo(),
            GlobalPageInfo::getBreadcrumbs(),
            GlobalPageInfo::getSection()
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

    /**
     * @return Section|null
     */
    public function getSection(): ?Section
    {
        return $this->section;
    }
}
