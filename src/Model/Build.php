<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

use Webmozart\Assert\Assert;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class Build implements ModelInterface
{
    /** @var int */
    public $buildNum;
    /** @var string */
    public $status;
    /** @var int */
    public $buildTimeMillis;
    /** @var Workflow */
    public $workflow;

    private function __construct(int $buildNum, string $status, int $buildTimeMillis, Workflow $workflow)
    {
        Assert::notEmpty($buildNum);
        Assert::notEmpty($status);
        Assert::notEmpty($buildTimeMillis);

        $this->buildNum = $buildNum;
        $this->buildTimeMillis = $buildTimeMillis;
        $this->status = $status;
        $this->workflow = $workflow;
    }

    public static function createFromNormalized(array $decodedValuesValues): Build
    {
        $build = new self(
            $decodedValuesValues['build_num'],
            $decodedValuesValues['status'],
            $decodedValuesValues['build_time_millis'],
            Workflow::createFromNormalized($decodedValuesValues['workflows'])
        );

        return $build;
    }

    public function normalize(): array
    {
        return [
            'build_num' => $this->buildNum,
            'status' => $this->status,
            'build_time_millis' => $this->buildTimeMillis,
            'workflows' => $this->workflow->normalize(),
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->normalize());
    }

    public function duration(): string
    {
        $hours = floor($this->buildTimeMillis / 1000 / 3600);
        $minutes = floor(($this->buildTimeMillis / 1000 / 60) % 60);
        $seconds = ($this->buildTimeMillis / 1000) % 60;

        return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
