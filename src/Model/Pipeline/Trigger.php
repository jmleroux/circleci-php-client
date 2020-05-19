<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model\Pipeline;

use DateTimeImmutable;
use Jmleroux\CircleCi\Model\ApiResultInterface;

/**
 * @author Benoit Jacquemont <benoit@akeneo.com>
 * @link https://circleci.com/docs/api/v2/#get-a-pipeline
 */
final class Trigger implements ApiResultInterface
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

    public function tyoe(): string
    {
        return $this->rawObject->type;
    }

    public function message(): string
    {
        return $this->rawObject->message;
    }

    public function actor(): Actor
    {
        return Actor::createFromApi($this->rawObject->actor);
    }

    public function receivedAt(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->rawObject->receivedAt);
    }
}
