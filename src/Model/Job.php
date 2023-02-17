<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

use DateTimeImmutable;

/**
 * @author Benoit Jacquemont <benoit@akeneo.com>
 * @link https://circleci.com/docs/api/v2/#operation/listWorkflowJobs
 */
class Job implements ApiResultInterface
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

    public function id(): string
    {
        return $this->rawObject->id;
    }

    public function name(): string
    {
        return $this->rawObject->name;
    }

    public function projectSlug(): string
    {
        return $this->rawObject->project_slug;
    }

    public function type(): string
    {
        return $this->rawObject->status;
    }

    public function status(): string
    {
        return $this->rawObject->status;
    }

    public function approvedBy(): ?string
    {
        return $this->rawObject->approved_by ?? null;
    }

    public function canceledBy(): ?string
    {
        return $this->rawObject->canceled_by ?? null;
    }

    /**
     * @return string[]
     */
    public function dependencies(): array
    {
        return $this->rawObject->dependencies;
    }

    public function jobNumber(): int
    {
        return $this->rawObject->job_number;
    }

    public function startedAt(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->rawObject->started_at);
    }

    public function stoppedAt(): ?DateTimeImmutable
    {
        if (null === $this->rawObject->stopped_at) {
            return null;
        }

        return new DateTimeImmutable($this->rawObject->stopped_at);
    }

    public function approvalRequestId(): string
    {
        return $this->rawObject->approval_request_id;
    }
}
