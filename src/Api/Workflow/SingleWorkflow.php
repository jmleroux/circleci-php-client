<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Workflow;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Workflow;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Get a workflow by id
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link https://circleci.com/docs/api/v2/#get-a-workflow
 */
class SingleWorkflow
{
    use ValidateClientVersionTrait;

    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->validateClientVersion($client, ['v2']);
        $this->client = $client;
    }

    public function execute(string $workflowId): Workflow
    {
        $uri = sprintf('workflow/%s', $workflowId);
        $response = $this->client->get($uri);

        return Workflow::createFromApi(json_decode((string) $response->getBody()));
    }
}
