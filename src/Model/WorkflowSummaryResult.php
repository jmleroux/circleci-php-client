<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

use DateTimeImmutable;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link https://circleci.com/docs/api/v2/#get-summary-metrics-for-a-project-39-s-workflows
 */
class WorkflowSummaryResult implements ApiResultInterface
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

    public function name(): string
    {
        return $this->rawObject->name;
    }

    public function windowStart(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->rawObject->window_start);
    }

    public function windowEnd(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->rawObject->window_end);
    }

    public function metrics(): JobMetrics
    {
        return JobMetrics::createFromApi($this->rawObject->metrics);
    }
}
