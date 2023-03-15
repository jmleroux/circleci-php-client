<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model\Pipeline;

use Jmleroux\CircleCi\Model\ApiResultInterface;
use Jmleroux\CircleCi\Model\Pipeline\Vcs\Commit;

/**
 * @author Brice Le Boulch <airmanbzh@gmail.com>
 * @link   https://circleci.com/docs/api/v2/index.html#operation/getPipelineById
 */
final class Vcs implements ApiResultInterface
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

    public function commit(): ?Commit
    {
        return isset($this->rawObject->commit) ? Commit::createFromApi($this->rawObject->commit) : null;
    }

    /**
     * Can be null in case of a triggered build
     * @see https://github.com/jmleroux/circleci-php-client/issues/51
     */
    public function branch(): ?string
    {
        return $this->rawObject->branch ?? null;
    }

    /**
     * In case of a triggered build
     * @see https://github.com/jmleroux/circleci-php-client/issues/51
     */
    public function tag(): ?string
    {
        return $this->rawObject->tag ?? null;
    }

    public function reviewId(): ?string
    {
        return $this->rawObject->review_id ?? null;
    }

    public function reviewUrl(): ?string
    {
        return $this->rawObject->review_url ?? null;
    }
}
