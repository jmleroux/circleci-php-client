<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Pipeline;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Workflow;

/**
 * Get all workflows of a pipeline
 *
 * @author Benoit Jacquemont <benoit@akeneo.com>
 */
class PipelineWorkflows
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Workflow[]
     */
    public function execute(string $pipelineId): array
    {
        $workflows = [];
        $uri = sprintf('pipeline/%s/workflow', $pipelineId);
        $params = [];

        $nextPageToken = null;
        do {
            if (null !== $nextPageToken) {
                $params['page-token'] = $nextPageToken;
            }

            $response = json_decode((string) $this->client->get($uri, $params)->getBody());
            $nextPageToken = $response->next_page_token;

            foreach($response->items as $item) {
                $workflows[] = Workflow::createFromApi($item);
            }
        } while (null !== $nextPageToken);

        return $workflows;
    }
}
