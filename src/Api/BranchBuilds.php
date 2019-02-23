<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api;

use GuzzleHttp\Client;
use Jmleroux\CircleCi\Model\Job;

class BranchBuilds
{
    /** @var string */
    private $token;
    /** @var string */
    private $vcs;
    /** @var string */
    private $username;
    /** @var string */
    private $reponame;

    public function __construct(string $token, string $vcs, string $username, string $reponame)
    {
        $this->token = $token;
        $this->vcs = $vcs;
        $this->username = $username;
        $this->reponame = $reponame;
    }

    /**
     * @return Job[]
     */
    public function execute(string $branch): array
    {
        $client = new Client(['base_uri' => 'https://circleci.com/api/v1.1/']);
        $uri = sprintf(
            'project/%s/%s/%s/tree/%s?circle-token=:%s',
            $this->vcs,
            $this->username,
            $this->reponame,
            $branch,
            $this->token
        );

        $response = $client->get($uri, [
            'headers' => ['Accept' => 'application/json'],
        ]);

        $builds = json_decode((string)$response->getBody(), true);

        $results = [];
        foreach ($builds as $build) {
            $results[] = Job::createFromNormalized($build);
        }

        return $results;
    }
}
