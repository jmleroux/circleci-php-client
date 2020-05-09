<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

use DateTimeImmutable;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class DurationMetrics
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

    public function min(): int
    {
        return $this->rawObject->min;
    }

    public function mean(): int
    {
        return $this->rawObject->mean;
    }

    public function median(): int
    {
        return $this->rawObject->median;
    }

    public function p95(): int
    {
        return $this->rawObject->p95;
    }

    public function max(): int
    {
        return $this->rawObject->max;
    }

    public function standardDeviation(): int
    {
        return $this->rawObject->standard_deviation;
    }
}
