<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model\Pipeline;

use DateTimeImmutable;
use Jmleroux\CircleCi\Model\ApiResultInterface;

/**
 * @author Benoit Jacquemont <benoit@akeneo.com>
 * @link   https://circleci.com/docs/api/v2/index.html#operation/getPipelineById
 */
final class Trigger implements ApiResultInterface
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

    public function type(): string
    {
        return $this->rawObject->type;
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
