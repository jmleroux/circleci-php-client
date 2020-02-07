<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\V2\Pipeline;

use Jmleroux\CircleCi\Client;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class PipelineWorkflows
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function execute(string $pipelineId): ?\stdClass
    {
        $uri = sprintf('pipeline/%s/workflow', $pipelineId);

        $response = $this->client->get($uri);

        return json_decode((string)$response->getBody());
    }
}
