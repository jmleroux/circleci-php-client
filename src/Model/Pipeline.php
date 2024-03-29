<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

use DateTimeImmutable;
use Jmleroux\CircleCi\Model\Pipeline\Error;
use Jmleroux\CircleCi\Model\Pipeline\Trigger;
use Jmleroux\CircleCi\Model\Pipeline\Vcs;

/**
 * @author Benoit Jacquemont <benoit@akeneo.com>
 */
class Pipeline
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

    /**
     * @return Error[]
     */
    public function errors(): array
    {
        $errors = [];
        foreach ($this->rawObject->errors as $error) {
            $errors[] = Error::createFromApi($error);
        };

        return $errors;
    }

    public function projectSlug(): string
    {
        return $this->rawObject->project_slug;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->rawObject->updated_at);
    }

    public function number(): int
    {
        return $this->rawObject->number;
    }

    public function state(): string
    {
        return $this->rawObject->state;
    }

    public function createdAt(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->rawObject->created_at);
    }

    public function trigger(): Trigger
    {
        return Trigger::createFromApi($this->rawObject->trigger);
    }

    public function vcs(): Vcs
    {
        return Vcs::createFromApi($this->rawObject->vcs);
    }
}
