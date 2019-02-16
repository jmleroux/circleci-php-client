<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

use Webmozart\Assert\Assert;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class Workflow implements ModelInterface
{
    /** @var string */
    public $workflowId;
    /** @var string */
    public $workflowName;
    /** @var string */
    public $jobName;
    /** @var string */
    public $jobId;

    private function __construct(string $workflowId, string $workflowName, string $jobName, string $jobId)
    {
        Assert::notEmpty($workflowId);
        Assert::notEmpty($workflowName);

        $this->workflowId = $workflowId;
        $this->workflowName = $workflowName;
        $this->jobName = $jobName;
        $this->jobId = $jobId;
    }

    public static function createFromNormalized(array $decodedValuesValues): Workflow
    {
        $workflow = new self(
            $decodedValuesValues['workflow_id'],
            $decodedValuesValues['workflow_name'],
            $decodedValuesValues['job_name'],
            $decodedValuesValues['job_id']
        );

        return $workflow;
    }

    public function normalize(): array
    {
        return [
            'workflow_id' => $this->workflowId,
            'workflow_name' => $this->workflowName,
            'job_name' => $this->jobName,
            'job_id' => $this->jobId,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->normalize());
    }

    public function url(): string
    {
        return sprintf('https://circleci.com/workflow-run/%s', $this->workflowId);
    }
}
