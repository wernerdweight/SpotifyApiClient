<?php
declare(strict_types=1);

namespace WernerDweight\SpotifyApiClient\Exception;

abstract class AbstractException extends \Exception implements \Throwable
{
    /** @var int */
    private const EXCEPTION_UNKNOWN = 1;

    /** @var string[] */
    protected static $messages = [
        self::EXCEPTION_UNKNOWN => 'An unknown exception has occured!',
    ];

    /**
     * @param int    $code
     * @param string ...$payload
     */
    public function __construct(int $code, string ...$payload)
    {
        if (true !== array_key_exists($code, static::$messages)) {
            $code = self::EXCEPTION_UNKNOWN;
        }

        $message = static::$messages[$code];

        if (true !== empty($payload)) {
            $message = sprintf($message, ...$payload);
        }
        parent::__construct($message, $code);
    }
}
