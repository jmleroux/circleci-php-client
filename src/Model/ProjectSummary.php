<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link   https://circleci.com/docs/api/v2/index.html#operation/getProjectWorkflowsPageData
 */
class ProjectSummary implements ApiResultInterface
{
    private function __construct(private readonly \stdClass $rawObject)
    {
    }

    public static function createFromApi(\stdClass $rawObject): self
    {
        return new self($rawObject);
    }

    public function rawValues(): \stdClass
    {
        return $this->rawObject;
    }

    public function orgId(): ?string
    {
        return $this->rawObject->org_id;
    }

    public function projectId(): ?string
    {
        return $this->rawObject->project_id;
    }

    public function projectData(): \stdClass
    {
        return $this->rawObject->project_data;
    }

    /**
     * @return \stdClass[]
     */
    public function projectWorkflowData(): array
    {
        return $this->rawObject->project_workflow_data;
    }

    /**
     * @return \stdClass[]
     */
    public function projectWorkflowBranchData(): array
    {
        return $this->rawObject->project_workflow_branch_data;
    }

    /**
     * @return string[]
     */
    public function allBranches(): array
    {
        return $this->rawObject->all_branches;
    }

    /**
     * @return string[]
     */
    public function allWorkflows():array
    {
        return $this->rawObject->all_workflows;
    }
}
