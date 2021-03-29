<?php


namespace OpenDocs\UrlFetcher;


interface UrlFetcher
{
    public function getUrl(string $uri);
}