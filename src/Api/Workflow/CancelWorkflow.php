<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Workflow;

use Jmleroux\CircleCi\Client;

/**
 * Cancel a workflow by id
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class CancelWorkflow
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function execute(string $workflowId): void
    {
        $uri = sprintf('workflow/%s/cancel', $workflowId);
        $this->client->post($uri);
    }
}
