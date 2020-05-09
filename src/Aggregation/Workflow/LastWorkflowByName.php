<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Aggregation\Workflow;

use Jmleroux\CircleCi\Api\Workflow\SingleWorkflow;
use Jmleroux\CircleCi\Api\Workflow\WorkflowRecentRuns;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Workflow;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Find last execution of a workflow by its name and optionaly by branch
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class LastWorkflowByName
{
    use ValidateClientVersionTrait;

    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->validateClientVersion($client, ['v2']);
        $this->client = $client;
    }

    public function execute(string $projectSlug, string $workflowName, ?string $branch): ?Workflow
    {
        $recentRuns = (new WorkflowRecentRuns($this->client))->execute(
            $projectSlug,
            $workflowName,
            null !== $branch ? ['branch' => $branch] : []
        );

        if (0 === count($recentRuns->items)) {
            return null;
        }

        return (new SingleWorkflow($this->client))->execute($recentRuns->items[0]->id);
    }
}
