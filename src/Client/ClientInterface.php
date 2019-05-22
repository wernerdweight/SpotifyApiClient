<?php
declare(strict_types=1);

namespace WernerDweight\SpotifyApiClient\Client;

interface ClientInterface
{
    /**
     * @return string
     */
    public function getClientType(): string;
}
