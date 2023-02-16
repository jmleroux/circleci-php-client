<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Client
{
    protected HttpClientInterface $client;

    public function __construct(private readonly string $token, private readonly ?string $version = 'v1.1')
    {
        $baseUri = sprintf('https://circleci.com/api/%s/', $version);
        $this->client = HttpClient::create(['base_uri' => $baseUri]);
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function get(string $url, array $params = []): ResponseInterface
    {
        return $this->client->request(
            'GET',
            $url,
            [
                'query' => $params,
                'headers' => [
                    'Accept' => 'application/json',
                    'Circle-Token' => $this->token,
                ],
            ]
        );
    }

    public function post(string $url, array $params = []): ResponseInterface
    {
        return $this->client->request(
            'POST',
            $url,
            [
                'query' => $params,
                'headers' => [
                    'Accept' => 'application/json',
                    'Circle-Token' => $this->token,
                ],
            ]
        );
    }

    public function delete(string $url, array $params = []): ResponseInterface
    {
        return $this->client->request(
            'DELETE',
            $url,
            [
                'query' => $params,
                'headers' => [
                    'Accept' => 'application/json',
                    'Circle-Token' => $this->token,
                ],
            ]
        );
    }
}
