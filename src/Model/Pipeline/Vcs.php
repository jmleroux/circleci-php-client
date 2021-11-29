<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model\Pipeline;

use Jmleroux\CircleCi\Model\ApiResultInterface;
use Jmleroux\CircleCi\Model\Pipeline\Vcs\Commit;

/**
 * @author Brice Le Boulch <airmanbzh@gmail.com>
 * @link https://circleci.com/docs/api/v2/#get-a-pipeline
 */
final class Vcs implements ApiResultInterface
{
    /** @var \stdClass */
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

    public function originRepositoryUrl(): string
    {
        return $this->rawObject->origin_repository_url;
    }

    public function targetRepositoryUrl(): string
    {
        return $this->rawObject->target_repository_url;
    }

    public function revision(): string
    {
        return $this->rawObject->revision;
    }

    public function providerName(): string
    {
        return $this->rawObject->provider_name;
    }

    public function commit(): Commit
    {
        return Commit::createFromApi($this->rawObject->actor);
    }

    public function branch(): string
    {
        return $this->rawObject->branch;
    }
}
