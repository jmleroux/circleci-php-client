<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\V2\Workflow;

use Jmleroux\CircleCi\Client;

/**
 * Get a workflow by id
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class SingleWorkflow
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function execute(string $workflowId): ?\stdClass
    {
        $uri = sprintf('workflow/%s', $workflowId);

        $response = $this->client->get($uri);

        return json_decode((string) $response->getBody());
    }
}
