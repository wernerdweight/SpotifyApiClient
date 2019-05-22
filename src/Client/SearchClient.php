<?php
declare(strict_types=1);

namespace WernerDweight\SpotifyApiClient\Client;

use Safe\Exceptions\StringsException;
use WernerDweight\Curler\Request;
use WernerDweight\Curler\Response;
use WernerDweight\SpotifyApiClient\Exception\SearchClientException;

class SearchClient extends AbstractClient
{
    /** @var string */
    private const ENDPOINT = 'https://api.spotify.com/v1/search';

    /** @var string */
    public const SEARCH_TYPE_ALBUM = 'album';
    /** @var string */
    public const SEARCH_TYPE_ARTIST = 'artist';
    /** @var string */
    public const SEARCH_TYPE_PLAYLIST = 'playlist';
    /** @var string */
    public const SEARCH_TYPE_TRACK = 'track';

    /** @var string[] */
    private const AVAILABLE_SEARCH_TYPES = [
        self::SEARCH_TYPE_ALBUM,
        self::SEARCH_TYPE_ARTIST,
        self::SEARCH_TYPE_PLAYLIST,
        self::SEARCH_TYPE_TRACK,
    ];

    /** @var int */
    private const MINIMUM_LIMIT = 1;
    /** @var int */
    private const DEFAULT_LIMIT = 20;
    /** @var int */
    private const MAXIMUM_LIMIT = 50;

    /** @var int */
    private const MINIMUM_OFFSET = 0;
    /** @var int */
    private const DEFAULT_OFFSET = 0;
    /** @var int */
    private const MAXIMUM_OFFSET = 10000;

    /**
     * @param array $types
     *
     * @return string
     */
    private function prepareSearchTypes(array $types): string
    {
        return implode(',', array_map(function (string $type): string {
            if (in_array($type, self::AVAILABLE_SEARCH_TYPES, true)) {
                return $type;
            }
            throw new SearchClientException(
                SearchClientException::INVALID_SEARCH_TYPE,
                $type,
                implode(', ', self::AVAILABLE_SEARCH_TYPES)
            );
        }, $types));
    }

    /**
     * @param int $limit
     *
     * @return int
     *
     * @throws SearchClientException
     */
    private function prepareLimit(int $limit): int
    {
        if ($limit < self::MINIMUM_LIMIT || $limit > self::MAXIMUM_LIMIT) {
            throw new SearchClientException(
                SearchClientException::INVALID_LIMIT,
                (string)$limit,
                (string)self::MINIMUM_LIMIT,
                (string)self::MAXIMUM_LIMIT
            );
        }
        return $limit;
    }

    /**
     * @param int $offset
     *
     * @return int
     *
     * @throws SearchClientException
     */
    private function prepareOffset(int $offset): int
    {
        if ($offset < self::MINIMUM_OFFSET || $offset > self::MAXIMUM_OFFSET) {
            throw new SearchClientException(
                SearchClientException::INVALID_OFFSET,
                (string)$offset,
                (string)self::MINIMUM_OFFSET,
                (string)self::MAXIMUM_OFFSET
            );
        }
        return $offset;
    }

    /**
     * @param string      $authorizationToken
     * @param string      $query
     * @param array       $types
     * @param string|null $market
     * @param int         $limit
     * @param int         $offset
     * @param bool|null   $includeExternalAudio
     *
     * @return Response
     *
     * @throws SearchClientException
     * @throws StringsException
     */
    public function search(
        string $authorizationToken,
        string $query,
        array $types,
        ?string $market = null,
        int $limit = self::DEFAULT_LIMIT,
        int $offset = self::DEFAULT_OFFSET,
        ?bool $includeExternalAudio = null
    ): Response {
        $payload = [
            'q' => $query,
            'type' => $this->prepareSearchTypes($types),
            'limit' => $this->prepareLimit($limit),
            'offset' => $this->prepareOffset($offset),
        ];

        if (null !== $market) {
            $payload['market'] = $market;
        }
        if (true === $includeExternalAudio) {
            $payload['include_external'] = 'audio';
        }

        $request = (new Request())
            ->setEndpoint(self::ENDPOINT)
            ->setMethod('GET')
            ->setBearerAuthorization($authorizationToken)
            ->setPayload($payload)
        ;

        return $this->curler->request($request);
    }
}
