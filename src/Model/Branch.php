<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class Branch
{
    /** @var string */
    private $name;
    /** @var array */
    private $runningBuilds = [];

    private function __construct(string $name, array $runningBuilds)
    {
        $this->name = $name;
        $this->runningBuilds = $runningBuilds;
    }

    public static function createFromNormalized(string $name, array $decodedValues): Branch
    {
        return new self($name, $decodedValues['running_builds']);
    }

    public function normalize(): array
    {
        return [
            'name' => $this->name,
            'running_builds' => $this->runningBuilds,
        ];
    }
}
