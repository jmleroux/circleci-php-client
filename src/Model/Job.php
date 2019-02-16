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
    public $reponame;
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
    /** @var Workflow */
    public $workflow;

    private function __construct(
        string $vcsUrl,
        string $buildUrl,
        int $buildNum,
        string $reponame,
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
        $this->reponame = $reponame;
    }

    public static function createFromNormalized(array $decodedValues): Job
    {
        $project = new self(
            $decodedValues['vcs_url'],
            $decodedValues['build_url'],
            $decodedValues['build_num'],
            $decodedValues['reponame'],
            $decodedValues['branch'],
            new \DateTime($decodedValues['start_time']),
            new \DateTime($decodedValues['stop_time']),
            $decodedValues['build_time_millis'],
            $decodedValues['outcome'],
            $decodedValues['status']
        );

        foreach ($decodedValues['steps'] as $stepValues) {
            $step = Step::createFromNormalized($stepValues);
            $project->steps[$step->name] = $step;
        }

        if (isset($decodedValues['workflows'])) {
            $project->addWorkflow(Workflow::createFromNormalized($decodedValues['workflows']));
        }

        return $project;
    }

    private function addWorkflow(Workflow $workflow)
    {
        $this->workflow = $workflow;
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
            'workflows' => $this->workflow ? $this->workflow->normalize() : null,
        ];
    }

    public function duration(): string
    {
        $hours = floor($this->buildTimeMillis / 1000 / 3600);
        $minutes = floor(($this->buildTimeMillis / 1000 / 60) % 60);
        $seconds = ($this->buildTimeMillis / 1000) % 60;

        return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
