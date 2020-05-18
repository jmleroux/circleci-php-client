<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Workflow;

use Jmleroux\CircleCi\Api\Pipeline\AllPipelines;
use Jmleroux\CircleCi\Api\Pipeline\PipelineWorkflows;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Pipeline;
use Jmleroux\CircleCi\Model\Workflow;

/**
 * Find last execution of a workflow by its name and optionaly by branch
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class LastWorkflowByName
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function execute(string $projectSlug, string $workflowName, ?string $branch): ?Workflow
    {
        $query = new AllPipelines($this->client);
        $pipelines = $query->execute($projectSlug, null, $branch);

        if (0 === count($pipelines)) {
            return null;
        }

        foreach ($pipelines as $pipeline) {
            $workflow = $this->getWorkflowByName($pipeline, $workflowName);
            if (null !== $workflow) {
                return $workflow;
            }
        }

        return null;
    }

    private function getWorkflowByName(Pipeline $pipeline, string $workflowName): ?Workflow
    {
        $query = new PipelineWorkflows($this->client);
        $workflows = $query->execute($pipeline->id());
        if (0 === count($workflows)) {
            return null;
        }
        foreach ($workflows as $workflow) {
            if ($workflowName === $workflow->name()) {
                return $workflow;
            }
        }

        return null;
    }
}
