<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Insights;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Project;
use Jmleroux\CircleCi\Model\ProjectSummary as ProjectSummaryModel;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Get summary metrics and trends for a project at workflow and branch level.
 *
 * Workflow runs going back at most 90 days
 * are included in the aggregation window. Trends are only supported upto last 30 days. Metrics are refreshed daily,
 * and thus may not include executions from the last 24 hours. Please note that Insights is not a real time financial
 * reporting tool and should not be used for credit reporting. The most up to date credit information can be found in
 * Plan Overview in the CircleCI UI.
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link   https://circleci.com/docs/api/v2/index.html#operation/getProjectWorkflowsPageData
 */
class ProjectSummary
{
    use ValidateClientVersionTrait;

    public function __construct(private readonly Client $client)
    {
        $this->validateClientVersion($client, ['v2']);
    }

    public function execute(string $projectSlug): ProjectSummaryModel
    {
        $uri = sprintf('insights/pages/%s/summary', $projectSlug);
        $response = $this->client->get($uri);

        return ProjectSummaryModel::createFromApi(
            \json_decode($response->getContent())
        );
    }
}
