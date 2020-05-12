<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

use DateTimeImmutable;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link   https://circleci.com/docs/api/#recent-builds-for-a-single-project
 */
class BuildSummary implements ApiResultInterface
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

    public function buildUrl(): string
    {
        return $this->rawObject->build_url;
    }

    public function buildNum(): int
    {
        return $this->rawObject->build_num;
    }

    public function branch(): string
    {
        return $this->rawObject->branch;
    }

    public function vcsRevision(): string
    {
        return $this->rawObject->vcs_revision;
    }

    public function committerName(): string
    {
        return $this->rawObject->committer_name;
    }

    public function committerEmail(): string
    {
        return $this->rawObject->committer_email;
    }

    public function subject(): string
    {
        return $this->rawObject->subject;
    }

    public function body(): string
    {
        return $this->rawObject->body;
    }

    public function why(): string
    {
        return $this->rawObject->why;
    }

    public function dontBuild(): ?string
    {
        return $this->rawObject->dont_build;
    }

    public function queuedAt(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->rawObject->queued_at);
    }

    public function startTime(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->rawObject->start_time);
    }

    public function stopTime(): ?DateTimeImmutable
    {
        return $this->rawObject->stop_time ? new DateTimeImmutable($this->rawObject->stop_time) : null;
    }

    public function buildTimeMillis(): ?int
    {
        return $this->rawObject->build_time_millis ?? null;
    }

    public function username(): string
    {
        return $this->rawObject->username;
    }

    public function reponame(): string
    {
        return $this->rawObject->reponame;
    }

    public function lifecycle(): string
    {
        return $this->rawObject->lifecycle;
    }

    public function outcome(): string
    {
        return $this->rawObject->outcome;
    }

    public function status(): string
    {
        return $this->rawObject->status;
    }
}
