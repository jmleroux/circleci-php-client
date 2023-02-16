<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration;

use Jmleroux\CircleCi\Client;
use Symfony\Component\HttpClient\HttpClient;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class TestClient extends Client
{
    public function __construct(
        string $mockServerBaseUrl,
        string $token,
        ?string $version = 'v1.1'
    ) {
        $baseUri = sprintf('%s/api/%s/', $mockServerBaseUrl, $version);
        $this->client = HttpClient::create(['base_uri' => $baseUri]);
        $this->token = $token;
    }
}
