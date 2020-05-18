<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

use DateTimeImmutable;

/**
 * @author Benoit Jacquemont <benoit@akeneo.com>
 */
class Job
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

    public function canceledBy(): string
    {
        return $this->rawObject->canceled_by;
    }

    public function dependencies(): array
    {
        return $this->rawObject->dependencies;
    }

    public function jobNumber(): string
    {
        return $this->rawObject->job_number;
    }

    public function startedAt(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->rawObject->started_at);
    }

    public function id(): string
    {
        return $this->rawObject->id;
    }

    public function name(): string
    {
        return $this->rawObject->name;
    }

    public function approvedBy(): string
    {
        return $this->rawObject->approved_by;
    }

    public function projectSlug(): string
    {
        return $this->rawObject->project_slug;
    }

    public function status(): string
    {
        return $this->rawObject->status;
    }

    public function type(): string
    {
        return $this->rawObject->status;
    }

    public function stoppedAt(): ?DateTimeImmutable
    {
        if (null === $this->rawObject->stopped_at) {
            return null;
        }

        return new DateTimeImmutable($this->rawObject->stopped_at);
    }
}
