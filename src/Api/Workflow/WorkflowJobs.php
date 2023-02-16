<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Workflow;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Job;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Get a workflow's jobs
 * Returns a sequence of jobs for a workflow.
 *
 * @author Benoit Jacquemont <benoit@akeneo.com>
 * @link https://circleci.com/docs/api/v2/#get-a-workflow-39-s-jobs
 */
class WorkflowJobs
{
    use ValidateClientVersionTrait;

    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->validateClientVersion($client, ['v2']);
        $this->client = $client;
    }

    /**
     * @return Job[]
     */
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

            $response = json_decode((string) $this->client->get($uri, $params)->getContent());
            $nextPageToken = $response->next_page_token;

            foreach ($response->items as $item) {
                $jobs[] = Job::createFromApi($item);
            }
        } while (null !== $nextPageToken);

        return $jobs;
    }
}
