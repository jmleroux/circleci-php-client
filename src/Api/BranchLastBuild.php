<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api;

use GuzzleHttp\Client;
use Jmleroux\CircleCi\Model\Job;
use Psr\Http\Message\ResponseInterface;

class BranchLastBuild
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
     * @return Job
     */
    public function execute(string $branch): ?Job
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

        $builds = $this->parseResponse($response);
        if (null === $builds || 0 === count($builds)) {
            return null;
        }

        return Job::createFromNormalized($builds[0]);
    }

    private function parseResponse(ResponseInterface $response): ?array
    {
        if (200 !== $response->getStatusCode()) {
            return null;
        }

        return json_decode((string)$response->getBody(), true);
    }
}
