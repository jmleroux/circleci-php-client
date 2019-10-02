<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api;

use Jmleroux\CircleCi\Client;

/**
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
