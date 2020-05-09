<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Workflow;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Job;

/**
 * Get all workflows of a pipeline
 *
 * @author Benoit Jacquemont <benoit@akeneo.com>
 */
class WorkflowJobs
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function execute(string $workflowId): array
    {
        $jobs = [];
        $uri = sprintf('workflow/%s/job', $workflowId);
        $params = [];

        $nextPageToken = null;
        do {
            if (null !== $nextPageToken) {
                $params['page-token'] = $nextPageToken;
            }

            $response = json_decode((string) $this->client->get($uri, $params)->getBody());
            $nextPageToken = $response->next_page_token;

            foreach ($response->items as $item) {
                $jobs[] = Job::createFromApi($item);
            }
        } while (null !== $nextPageToken);

        return $jobs;
    }
}
