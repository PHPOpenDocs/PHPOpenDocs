<?php

declare(strict_types = 1);

namespace OpenDocs;

class Section
{
    // The prefix used for routing on this site
    private string $prefix;

    // The name of the section
    private string $name;

    private string $purpose;

    private SectionInfo $sectionInfo;

    private string|null $base_edit_url;

    public function __construct(
        string $prefix,
        string $name,
        string $purpose,
        SectionInfo $sectionInfo,
        string $base_edit_url
    ) {
        $this->prefix = $prefix;
        $this->name = $name;
        $this->purpose = $purpose;
        $this->sectionInfo = $sectionInfo;
        $this->base_edit_url = $base_edit_url;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPurpose(): string
    {
        return $this->purpose;
    }

    /**
     * @return SectionInfo
     */
    public function getSectionInfo(): SectionInfo
    {
        return $this->sectionInfo;
    }

    /**
     * @return string|null
     */
    public function getBaseEditUrl(): ?string
    {
        return $this->base_edit_url;
    }

    /**
     * @return ContentLink[]
     */
    public function getContentLinks(): array
    {
        return $this->sectionInfo->getContentLinks();
    }

    public function getDefaultCopyrightInfo(): CopyrightInfo
    {
        return $this->sectionInfo->getDefaultCopyrightInfo();
    }
}
