<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Project;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Clear project build cache.
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link https://circleci.com/docs/api/#clear-project-cache
 */
class ClearProjectCache
{
    use ValidateClientVersionTrait;

    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->validateClientVersion($client, ['v1.1']);
        $this->client = $client;
    }

    public function execute(
        string $vcsType,
        string $username,
        string $reponame,
        array $queryParameters = []
    ): string {
        $uri = sprintf('project/%s/%s/%s/build-cache', $vcsType, $username, $reponame);

        $response = $this->client->delete($uri, $queryParameters);

        return json_decode((string)$response->getBody())->status;
    }
}
