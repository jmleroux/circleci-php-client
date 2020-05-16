<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Workflow;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\JobSummaryResult;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Get summary metrics for a project workflow's jobs.
 * Job runs going back at most 90 days are included in the aggregation window.
 * Metrics are refreshed daily, and thus may not include executions from the last 24 hours.
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link   https://circleci.com/docs/api/v2/#get-summary-metrics-for-a-project-workflow-39-s-jobs
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
            $responseContent = json_decode((string) $response->getBody());
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
