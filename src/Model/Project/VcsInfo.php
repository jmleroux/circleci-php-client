<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model\Project;

use Jmleroux\CircleCi\Model\ApiResultInterface;

/**
 * @author Brice Le Boulch <airmanbzh@gmail.com>
 * @link   https://circleci.com/docs/api/v2/index.html#operation/getPipelineById
 */
final class VcsInfo implements ApiResultInterface
{
    private \stdClass $rawObject;

    private function __construct(\stdClass $rawObject)
    {
        $this->rawObject = $rawObject;
    }

    public static function createFromApi(\stdClass $rawObject): self
    {
        return new self($rawObject);
    }

    public function rawValues(): \stdClass
    {
        return $this->rawObject;
    }

    public function vcsUrl(): string
    {
        return $this->rawObject->vcs_url;
    }

    public function provider(): string
    {
        return $this->rawObject->provider;
    }

    public function defaultBranch(): string
    {
        return $this->rawObject->default_branch;
    }
}
