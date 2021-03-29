<?php


namespace OpenDocs\UrlFetcher;


class UrlFetcherException extends \Exception
{
    const RESPONSE_NOT_OK = "Response code %s is not ok.";

    public static function notOk(int $statusCode)
    {
        $message = sprintf(
            self::RESPONSE_NOT_OK,
            $statusCode
        );

        return new self($message);
    }
}
