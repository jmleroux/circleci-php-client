<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Workflow;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Cancel a workflow by id
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link https://circleci.com/docs/api/v2/#cancel-a-workflow
 */
class CancelWorkflow
{
    use ValidateClientVersionTrait;

    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->validateClientVersion($client, ['v2']);
        $this->client = $client;
    }

    public function execute(string $workflowId): void
    {
        $uri = sprintf('workflow/%s/cancel', $workflowId);
        $this->client->post($uri);
    }
}
