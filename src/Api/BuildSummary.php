<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Recent Builds For A Single Project
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link https://circleci.com/docs/api/#recent-builds-for-a-single-project
 */
class BuildSummary
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
    ): array {
        $uri = sprintf('project/%s/%s/%s', $vcsType, $username, $reponame);

        $response = $this->client->get($uri, $queryParameters);

        return json_decode((string)$response->getBody());
    }
}
