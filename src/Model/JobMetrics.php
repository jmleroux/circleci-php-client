<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class JobMetrics implements ApiResultInterface
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

    public function successRate(): float
    {
        return $this->rawObject->success_rate;
    }

    public function totalRuns(): int
    {
        return $this->rawObject->total_runs;
    }

    public function failedRuns(): int
    {
        return $this->rawObject->failed_runs;
    }

    public function successfulRuns(): int
    {
        return $this->rawObject->successful_runs;
    }

    public function throughput(): float
    {
        return $this->rawObject->throughput;
    }

    public function totalCreditsUsed(): int
    {
        return $this->rawObject->total_credits_used;
    }

    public function durationsMetrics(): DurationMetrics
    {
        return DurationMetrics::createFromApi($this->rawObject->duration_metrics);
    }
}
