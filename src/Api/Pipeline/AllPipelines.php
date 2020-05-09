<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Pipeline;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Retriece pipelines of a project, otpionaly filtered by branch.
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link https://circleci.com/docs/api/v2/#get-all-pipelines
 */
class AllPipelines
{
    use ValidateClientVersionTrait;

    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->validateClientVersion($client, ['v2']);
        $this->client = $client;
    }

    public function execute(string $projectSlug, ?string $branch): ?\stdClass
    {
        $uri = sprintf('project/%s/pipeline', $projectSlug);

        $params = [];
        if (null !== $branch) {
            $params['branch'] = $branch;
        }

        $response = $this->client->get($uri, $params);

        return json_decode((string)$response->getBody());
    }
}
