<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Project;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\WorkflowSummaryResult;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Get summary metrics for a project's workflows.
 * Workflow runs going back at most 90 days are included in the aggregation window.
 * Metrics are refreshed daily, and thus may not include executions from the last 24 hours.
 * Please note that Insights is not a real time financial reporting tool and should not be used for credit reporting.
 * The most up to date credit information can be found in Plan Overview in the CircleCI UI.
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link   https://circleci.com/docs/api/v2/#operation/getProjectWorkflowMetrics
 */
class ProjectSummaryMetrics
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
     * @return WorkflowSummaryResult[]
     */
    public function execute(
        string $projectSlug,
        array $queryParameters = [],
        $maxResults = 10
    ): array {
        $jobSummaries = [];
        $uri = sprintf('insights/%s/workflows', $projectSlug);

        $nextPageToken = $queryParameters['page-token'] ?? null;
        do {
            if (null !== $nextPageToken) {
                $queryParameters['page-token'] = $nextPageToken;
            }

            $response = $this->client->get($uri, $queryParameters);
            $responseContent = json_decode((string) $response->getBody());
            $nextPageToken = $responseContent->next_page_token;

            foreach ($responseContent->items as $item) {
                $jobSummaries[] = WorkflowSummaryResult::createFromApi($item);
                if (count($jobSummaries) >= $maxResults) {
                    break;
                }
            }
        } while (null !== $nextPageToken && count($jobSummaries) < $maxResults);

        return $jobSummaries;
    }
}
