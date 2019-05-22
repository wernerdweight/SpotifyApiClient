<?php
declare(strict_types=1);

namespace WernerDweight\SpotifyApiClientBundle\Exception;

class SearchClientException extends AbstractException
{
    /** @var int */
    public const INVALID_SEARCH_TYPE = 1;
    /** @var int */
    public const INVALID_LIMIT = 2;
    /** @var int */
    public const INVALID_OFFSET = 3;

    /** @var string[] */
    protected static $messages = [
        self::INVALID_SEARCH_TYPE => 'Invalid search type "%s". Pick one of the following: %s.',
        self::INVALID_LIMIT => 'Invalid limit "%d". Limit must be betwwen %d and %d.',
        self::INVALID_OFFSET => 'Invalid offset "%d". Offset must be betwwen %d and %d.',
    ];
}
