<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

use Jmleroux\CircleCi\Model\Project\VcsInfo;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link   https://circleci.com/docs/api/#get-all-followed-projects
 */
class Project implements ApiResultInterface
{
    /**
     * Raw object from Circle CI API
     */
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

    public function slug(): string
    {
        return $this->rawObject->slug;
    }

    public function name(): string
    {
        return $this->rawObject->slug;
    }

    public function id(): string
    {
        return $this->rawObject->slug;
    }

    public function organizationName(): string
    {
        return $this->rawObject->organization_name;
    }

    public function organizationSlug(): string
    {
        return $this->rawObject->organization_slug;
    }

    public function organizationId(): string
    {
        return $this->rawObject->organization_id;
    }

    public function vcsInfo(): VcsInfo
    {
        return VcsInfo::createFromApi($this->rawObject->vcs_info);
    }
}
