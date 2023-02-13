<?php

declare(strict_types = 1);

namespace OpenDocs;

use PHPOpenDocs\Types\PackageMarkdownPage;
use PHPOpenDocs\Types\RemoteMarkdownPage;

class GlobalPageInfo
{
    private static string|null $contentHtml = null;
    private static array $contentLinks = [];
    private static CopyrightInfo|null $copyrightInfo;
    private static Section|null $section;
    private static EditInfo|null $editInfo;
    private static string|null $title = null;
    private static string|null $current_path = null;
    private static Breadcrumbs|null $breadcrumbs = null;
    private static PrevNextLinks|null $prevNextLinks = null;

    private function __construct()
    {
    }

    public static function create(
        string $contentHtml = null,
        array $contentLinks = null,
        CopyrightInfo $copyrightInfo = null,
        Section $section = null,
        EditInfo $editInfo = null,
        string $title = null,
        string $current_path = null,
        PrevNextLinks $prevNextLinks = null
    ): void {

        self::$contentHtml = $contentHtml;
        self::$contentLinks = $contentLinks;
        self::$copyrightInfo = $copyrightInfo;
        self::$section = $section;
        self::$editInfo = $editInfo ?? new EditInfo([]);
        self::$title = $title;
        self::$current_path = $current_path;
        self::$prevNextLinks = $prevNextLinks;

        if (self::$copyrightInfo === null) {
            self::$copyrightInfo = new CopyrightInfo();
        }

        self::calculateBreadcrumbs();
    }

    public static function createFromSection(
        Section $section,
        string $title,
        string $html = null,
        CopyrightInfo $copyrightInfo = null
    ): void {
        GlobalPageInfo::create(
            contentHtml: $html,
            contentLinks: $section->getContentLinks(),
            copyrightInfo: $copyrightInfo ?? $section->getDefaultCopyrightInfo(),
            section: $section,
            title: $title,
            current_path: getRequestPath(),
        );

        GlobalPageInfo::addEditInfoFromBacktrace('Edit page', 2);
    }

    public static function calculateBreadcrumbs(): void
    {
        $section = self::getSection();

        if ($section === null) {
            self::$breadcrumbs = Breadcrumbs::fromArray([
            ]);
            return;
        }

        $path = getRequestPath();
        if ($path === $section->getPrefix()) {
            self::$breadcrumbs = Breadcrumbs::fromArray([
                $section->getPrefix() => $section->getName(),
            ]);
        }
        else {
            self::$breadcrumbs = Breadcrumbs::fromArray([
                $section->getPrefix() => $section->getName(),
                $path => self::$title
            ]);
        }
    }


    public static function addRemoteMarkDownEditInfo(
        string $name,
        RemoteMarkdownPage $remoteMarkdownPage
    ): void {
        self::$editInfo->addEditInfo(new EditInfo([
            $name => $remoteMarkdownPage->getEditUrl()
        ]));
    }

    public static function addMarkDownEditInfo(
        string $name,
        PackageMarkdownPage $packageMarkdownPage
    ): void {

        self::$editInfo->addEditInfo(new EditInfo([
            $name => $packageMarkdownPage->getEditUrl()
        ]));
    }

    public static function addEditInfoFromBacktrace(string $name, int $level): void
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $setupPage = $backtrace[$level];
        $edit_url = self::$section->getBaseEditUrl() . '/' . normaliseFilePath($setupPage["file"]);

        self::$editInfo->addEditInfo(new EditInfo([$name => $edit_url]));
    }

    public static function setTitleFromCurrentPath(): void
    {
        $prefix = self::$section->getPrefix();

        $path = getRequestPath();

        if (str_starts_with($path, $prefix) === true) {
            $path = str_replace($prefix, '', $path);
        }

        foreach (self::getContentLinks() as $contentLink) {
            if ($path === $contentLink->getPath()) {
                self::setTitle($contentLink->getDescription());
            }
        }
    }


    public static function setTitle(string $title): void
    {
        self::$title = $title;
    }

    /**
     * @param string|null $contentHtml
     */
    public static function setContentHtml(?string $contentHtml): void
    {
        self::$contentHtml = $contentHtml;
    }

    /**
     * @param string|null $current_path
     */
    public static function setCurrentPath(?string $current_path): void
    {
        self::$current_path = $current_path;
    }

    public static function setBreadcrumbsFromArray(array $breadcrumbs): void
    {
        self::$breadcrumbs = Breadcrumbs::fromArray($breadcrumbs);
    }

    public static function addCopyrightInfo(CopyrightInfo $copyright_info): void
    {
        self::$copyrightInfo = $copyright_info;
    }

    public static function addCopyrightInfoFromStrings(string $name, string $url): void
    {
        self::$copyrightInfo->addNameWithLink($name, $url);
    }


    /**
     * @return \OpenDocs\ContentLink[]
     */
    public static function getContentLinks(): array
    {
        return self::$contentLinks;
    }

    /**
     * @return \OpenDocs\CopyrightInfo|null
     */
    public static function getCopyrightInfo(): ?\OpenDocs\CopyrightInfo
    {
        return self::$copyrightInfo;
    }

    /**
     * @return \OpenDocs\Section|null
     */
    public static function getSection(): ?\OpenDocs\Section
    {
        return self::$section;
    }

    /**
     * @return \OpenDocs\EditInfo|null
     */
    public static function getEditInfo(): ?\OpenDocs\EditInfo
    {
        return self::$editInfo;
    }

    public static function addEditInfo(EditInfo $editInfo): void
    {
        if (self::$editInfo === null) {
            self::$editInfo = $editInfo;
            return;
        }

        self::$editInfo->addEditInfo($editInfo);
    }

    public static function addEditInfoFromStrings(string $name, string $url): void
    {
        $editInfo = new EditInfo([$name => $url]);

        if (self::$editInfo === null) {
            self::$editInfo = $editInfo;
            return;
        }

        self::$editInfo->addEditInfo($editInfo);
    }


    /**
     * @return string|null
     */
    public static function getTitle(): ?string
    {
        return self::$title;
    }

    /**
     * @return string|null
     */
    public static function getCurrentPath(): ?string
    {
        return self::$current_path;
    }

    /**
     * @return string|null
     */
    public static function getContentHtml(): ?string
    {
        return self::$contentHtml;
    }

    /**
     * @return Breadcrumbs|null
     */
    public static function getBreadcrumbs(): ?Breadcrumbs
    {
        return self::$breadcrumbs;
    }

    /**
     * @param \OpenDocs\PrevNextLinks $prevNextLinks
     */
    public static function setPrevNextLinks(\OpenDocs\PrevNextLinks $prevNextLinks): void
    {
        self::$prevNextLinks = $prevNextLinks;
    }



    /**
     * @return \OpenDocs\PrevNextLinks|null
     */
    public static function getPrevNextLinks(): ?\OpenDocs\PrevNextLinks
    {
        return self::$prevNextLinks;
    }
}
