<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Workflow;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Job;
use Jmleroux\CircleCi\Model\WorkflowRun;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Get recent runs of a workflow. Runs going back at most 90 days are returned.
 * @todo Implement pagination
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link   https://circleci.com/docs/api/v2/#operation/getProjectWorkflowRuns
 */
class WorkflowRecentRuns
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
     * @return WorkflowRun[]
     */
    public function execute(string $projectSlug, string $workflowName, array $queryParameters = []): array
    {
        $workflowRuns = [];

        $uri = sprintf('insights/%s/workflows/%s', $projectSlug, $workflowName);

        $nextPageToken = null;
        do {
            if (null !== $nextPageToken) {
                $queryParameters['page-token'] = $nextPageToken;
            }

            $response = json_decode((string) $this->client->get($uri, $queryParameters)->getBody());
            $nextPageToken = $response->next_page_token;

            foreach ($response->items as $item) {
                $workflowRuns[] = WorkflowRun::createFromApi($item);
            }
        } while (null !== $nextPageToken);

        return $workflowRuns;
    }
}
