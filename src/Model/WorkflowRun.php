<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

use DateTimeImmutable;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class WorkflowRun
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

    public function status(): string
    {
        return $this->rawObject->status;
    }

    public function duration(): int
    {
        return $this->rawObject->duration;
    }

    public function createdAt(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->rawObject->created_at);
    }

    public function stoppedAt(): ?DateTimeImmutable
    {
        if (null === $this->rawObject->stopped_at) {
            return null;
        }

        return new DateTimeImmutable($this->rawObject->stopped_at);
    }
}
