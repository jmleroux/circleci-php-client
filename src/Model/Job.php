<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

use Webmozart\Assert\Assert;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class Job implements ModelInterface
{
    /** @var string */
    private $vcsUrl;
    /** @var string */
    private $buildUrl;
    /** @var int */
    private $buildNum;
    /** @var string */
    private $branch;
    /** @var \DateTime */
    private $startTime;
    /** @var \DateTime */
    private $stopTime;
    /** @var int */
    private $buildTimeMillis;
    /** @var string */
    private $outcome;
    /** @var string */
    private $status;
    /** @var Step[] */
    private $steps = [];

    private function __construct(
        string $vcsUrl,
        string $buildUrl,
        int $buildNum,
        string $branch,
        \DateTime $startTime,
        \DateTime $stopTime,
        int $buildTimeMillis,
        string $outcome,
        string $status
    ) {
        Assert::notEmpty($vcsUrl);
        Assert::notEmpty($startTime);
        Assert::notEmpty($stopTime);

        $this->vcsUrl = $vcsUrl;
        $this->buildUrl = $buildUrl;
        $this->buildNum = $buildNum;
        $this->branch = $branch;
        $this->startTime = $startTime;
        $this->stopTime = $stopTime;
        $this->buildTimeMillis = $buildTimeMillis;
        $this->outcome = $outcome;
        $this->status = $status;
    }

    public static function createFromJson(string $json): Job
    {
        $decoded = json_decode($json, true);

        $project = new self(
            $decoded['vcs_url'],
            $decoded['build_url'],
            $decoded['build_num'],
            $decoded['branch'],
            new \DateTime($decoded['start_time']),
            new \DateTime($decoded['stop_time']),
            $decoded['build_time_millis'],
            $decoded['outcome'],
            $decoded['status']
        );

        foreach ($decoded['steps'] as $stepValues) {
            $step = Step::createFromArray($stepValues);
            $project->steps[$step->name] = $step;
        }

        return $project;
    }

    public function toJson(): string
    {
        return json_encode($this->normalize());
    }

    public function normalize(): array
    {
        return [
            'vcsUrl' => $this->vcsUrl,
            'buildUrl' => $this->buildUrl,
            'buildNum' => $this->buildNum,
            'branch' => $this->branch,
            'startTime' => $this->startTime->format('Y-m-d H:i:s'),
            'stopTime' => $this->stopTime->format('Y-m-d H:i:s'),
            'buildTimeMillis' => $this->buildTimeMillis,
            'outcome' => $this->outcome,
            'status' => $this->status,
            'steps' => array_map(function (Step $step) {
                return $step->normalize();
            }, $this->steps),
        ];
    }
}
