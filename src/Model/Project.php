<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link   https://circleci.com/docs/api/#get-all-followed-projects
 */
class Project implements ApiResultInterface
{
    /**
     * Raw object from Circle CI API
     *
     * @var \stdClass
     */
    private $rawObject;

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

    public function followed(): bool
    {
        return $this->rawObject->followed ?? false;
    }

    public function username(): string
    {
        return $this->rawObject->username;
    }

    public function reponame(): string
    {
        return $this->rawObject->reponame;
    }

    public function branches(): \stdClass
    {
        return $this->rawObject->branches;
    }
}
