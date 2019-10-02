<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

class Client
{
    /** @var HttpClient */
    private $client;
    /** @var string */
    private $token;

    public function __construct(string $token, ?string $version = 'v1.1')
    {
        $baseUri = sprintf('https://circleci.com/api/%s/', $version);
        $this->client = new HttpClient(['base_uri' => $baseUri]);
        $this->token = $token;
    }

    public function get(string $uri, array $params = []): ResponseInterface
    {
        $params[] = sprintf('circle-token=%s', $this->token);
        $queryString = implode('&', $params);
        $uri .= sprintf('?%s', $queryString);

        return $this->client->get($uri, [
            'headers' => ['Accept' => 'application/json'],
        ]);
    }

    public function delete(string $uri, array $params = []): ResponseInterface
    {
        $params[] = sprintf('circle-token=%s', $this->token);
        $queryString = implode('&', $params);
        $uri .= sprintf('?%s', $queryString);

        return $this->client->delete($uri, [
            'headers' => ['Accept' => 'application/json'],
        ]);
    }
}
