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
    public $vcsUrl;
    /** @var string */
    public $buildUrl;
    /** @var int */
    public $buildNum;
    /** @var string */
    public $username;
    /** @var string */
    public $reponame;
    /** @var string */
    public $branch;
    /** @var \DateTime|null */
    public $startTime;
    /** @var \DateTime|null */
    public $stopTime;
    /** @var int */
    public $buildTimeMillis;
    /** @var string */
    public $outcome;
    /** @var string */
    public $status;
    /** @var User */
    public $user;
    /** @var Step[] */
    public $steps = [];
    /** @var Workflow */
    public $workflow;

    private function __construct(
        string $vcsUrl,
        string $buildUrl,
        int $buildNum,
        string $username,
        string $reponame,
        string $branch,
        ?\DateTime $startTime,
        ?\DateTime $stopTime,
        ?int $buildTimeMillis,
        ?string $outcome,
        string $status,
        User $user
    ) {
        Assert::notEmpty($vcsUrl);

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
        $this->username = $username;
        $this->user = $user;
    }

    public static function createFromNormalized(array $decodedValues): Job
    {
        $project = new self(
            $decodedValues['vcs_url'],
            $decodedValues['build_url'],
            $decodedValues['build_num'],
            $decodedValues['username'],
            $decodedValues['reponame'],
            $decodedValues['branch'],
            null !== $decodedValues['start_time'] ? new \DateTime($decodedValues['start_time']) : null,
            null !== $decodedValues['stop_time'] ? new \DateTime($decodedValues['stop_time']) : null,
            null !== $decodedValues['build_time_millis'] ? $decodedValues['build_time_millis'] : null,
            null !== $decodedValues['outcome'] ? $decodedValues['outcome'] : null,
            $decodedValues['status'],
            User::createFromNormalized($decodedValues['user'])
        );

        if (isset($decodedValues['steps'])) {
            foreach ($decodedValues['steps'] as $stepValues) {
                $step = Step::createFromNormalized($stepValues);
                $project->steps[$step->name] = $step;
            }
        }

        if (isset($decodedValues['workflows'])) {
            $project->addWorkflow(Workflow::createFromNormalized($decodedValues['workflows']));
        }

        return $project;
    }

    public function addWorkflow(Workflow $workflow)
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
            'startTime' => $this->startTime ? $this->startTime->format('Y-m-d H:i:s') : null,
            'stopTime' => $this->stopTime ? $this->stopTime->format('Y-m-d H:i:s') : null,
            'buildTimeMillis' => $this->buildTimeMillis,
            'username' => $this->username,
            'reponame' => $this->reponame,
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
