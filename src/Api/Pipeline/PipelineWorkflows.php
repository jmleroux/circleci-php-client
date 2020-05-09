<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Pipeline;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Get the workflows of a pipeline.
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link https://circleci.com/docs/api/v2/#get-a-pipeline-39-s-workflows
 */
class PipelineWorkflows
{
    use ValidateClientVersionTrait;

    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->validateClientVersion($client, ['v2']);
        $this->client = $client;
    }

    public function execute(string $pipelineId): ?\stdClass
    {
        $uri = sprintf('pipeline/%s/workflow', $pipelineId);

        $response = $this->client->get($uri);

        return json_decode((string)$response->getBody());
    }
}
