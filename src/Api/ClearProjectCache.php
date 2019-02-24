<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api;

use Jmleroux\CircleCi\Client;

/**
 * Clear project build cache.
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class ClearProjectCache
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function execute(
        string $vcsType,
        string $username,
        string $reponame,
        array $queryParameters = []
    ): \stdClass {
        $uri = sprintf('project/%s/%s/%s/build-cache', $vcsType, $username, $reponame);

        $response = $this->client->delete($uri, $queryParameters);

        return json_decode((string)$response->getBody());
    }
}
