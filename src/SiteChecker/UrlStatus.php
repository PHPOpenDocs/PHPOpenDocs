<?php

declare(strict_types = 1);

namespace SiteChecker;

class UrlStatus
{
    private int $status = 0;

    private string|null $error_message = null;

    public function __construct(
        private string $url,
        private string $origin_url
    ) {
    }

    public function setStatus(int $new_status): void
    {
        $this->status = $new_status;
    }

    public function setError(int $status_code, string $error_message): void
    {
        $this->status = $status_code;
        $this->error_message = $error_message;
    }

    public function setOk(): void
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
