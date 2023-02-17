<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Project;

use Jmleroux\CircleCi\Api\Insights\ProjectWorkflowsSummaryMetrics;
use Jmleroux\CircleCi\Client;

/**
 * Get summary metrics for a project's workflows.
 * Workflow runs going back at most 90 days are included in the aggregation window.
 * Metrics are refreshed daily, and thus may not include executions from the last 24 hours.
 * Please note that Insights is not a real time financial reporting tool and should not be used for credit reporting.
 * The most up to date credit information can be found in Plan Overview in the CircleCI UI.
 *
 * @author     jmleroux <jmleroux.pro@gmail.com>
 * @link       https://circleci.com/docs/api/v2/#operation/getProjectWorkflowMetrics
 *
 * @deprecated use ProjectWorSummaryMetrics
 */
class ProjectSummaryMetrics extends ProjectWorkflowsSummaryMetrics
{
    public function __construct(Client $client)
    {
        @trigger_error('ProjectSummaryMetrics is deprecated and will be removed.');

        parent::__construct($client);
    }
}
