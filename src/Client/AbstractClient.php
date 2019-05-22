<?php
declare(strict_types=1);

namespace WernerDweight\SpotifyApiClient\Client;

use WernerDweight\Curler\Curler;

abstract class AbstractClient implements ClientInterface
{
    /** @var Curler */
    protected $curler;

    /**
     * AbstractClient constructor.
     */
    public function __construct()
    {
        $this->curler = new Curler();
    }

    /**
     * @return string
     */
    public function getClientType(): string
    {
        return get_class($this);
    }
}
