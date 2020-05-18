<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model\Pipeline;

use DateTimeImmutable;

/**
 * @author Benoit Jacquemont <benoit@akeneo.com>
 */
final class Trigger
{
    /** @var string */
    private $type;

    /** @var DateTimeImmutable */
    private $receivedAt;

    /** @var string */
    private $actor;

    private function __construct(\StdObject $rawObject)
    {
        $this->type = $rawObject->type;
        $this->receivedAt = new DateTimeImmutable($rawObject->receivedAt);
        $this->actor = Actor::createFromApi($rawObject->actor);
    }

    public static function createFromApi(\stdClass $rawObject): self
    {
        return new self($rawObject);
    }

    public function tyoe(): string
    {
        return $this->type;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function actor(): Actor
    {
        return $this->actor;
    }
}
