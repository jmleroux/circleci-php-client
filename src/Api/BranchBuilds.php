<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api;

use Jmleroux\CircleCi\Client;

class BranchBuilds
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function execute(string $vcsType, string $username, string $reponame, string $branch): array
    {
        $uri = sprintf('project/%s/%s/%s/tree/%s', $vcsType, $username, $reponame, $branch);

        $response = $this->client->get($uri);

        return json_decode((string)$response->getBody(), true);
    }
}
