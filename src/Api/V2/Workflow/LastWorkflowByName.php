<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\V2\Workflow;

use Jmleroux\CircleCi\Api\V2\Pipeline\AllPipelines;
use Jmleroux\CircleCi\Api\V2\Pipeline\PipelineWorkflows;
use Jmleroux\CircleCi\Client;

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

    public function execute(string $workflowName, ?string $branch): ?\stdClass
    {
        $query = new AllPipelines($this->client);
        $pipelines = $query->execute('gh/jmleroux/circleci-php-client', $branch);

        foreach ($pipelines->items as $pipeline) {
            $query = new PipelineWorkflows($this->client);
            $workflows = $query->execute($pipeline->id);
            $workflow = $workflows->items[0];

            if ($workflowName === $workflow->name) {
                $query = new SingleWorkflow($this->client);

                return $query->execute($workflow->id);
            }
        }

        return null;
    }
}
