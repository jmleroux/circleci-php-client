<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Workflow;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\JobSummaryResult;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Get recent runs of a job within a workflow.
 * Runs going back at most 90 days are returned.
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link   https://circleci.com/docs/api/v2/#operation/getProjectJobRuns
 */
class WorkflowSummaryMetrics
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
     * @return JobSummaryResult[]
     */
    public function execute(
        string $projectSlug,
        string $workflowName,
        array $queryParameters = [],
        $maxResults = 10
    ): array {
        $jobSummaries = [];
        $uri = sprintf('insights/%s/workflows/%s/jobs', $projectSlug, $workflowName);

        $nextPageToken = $queryParameters['page-token'] ?? null;
        do {
            if (null !== $nextPageToken) {
                $queryParameters['page-token'] = $nextPageToken;
            }

            $response = $this->client->get($uri, $queryParameters);
            $responseContent = json_decode((string) $response->getContent());
            $nextPageToken = $responseContent->next_page_token;

            foreach ($responseContent->items as $item) {
                $jobSummaries[] = JobSummaryResult::createFromApi($item);
                if (count($jobSummaries) >= $maxResults) {
                    break;
                }
            }
        } while (null !== $nextPageToken && count($jobSummaries) < $maxResults);

        return $jobSummaries;
    }
}
