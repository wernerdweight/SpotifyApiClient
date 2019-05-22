<?php
declare(strict_types=1);

namespace WernerDweight\SpotifyApiClient\Client;

use WernerDweight\Curler\Request;
use WernerDweight\Curler\Response;

class AuthorizationClient extends AbstractClient
{
    /** @var string */
    private const ENDPOINT = 'https://accounts.spotify.com/api/token';

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @return Response
     */
    public function authorizeWithClientCredentials(string $clientId, string $clientSecret): Response
    {
        $request = (new Request())
            ->setEndpoint(self::ENDPOINT)
            ->setMethod('POST')
            ->setAuthentication($clientId, $clientSecret)
            ->setPayload(['grant_type' => 'client_credentials'])
        ;

        return $this->curler->request($request);
    }
}
