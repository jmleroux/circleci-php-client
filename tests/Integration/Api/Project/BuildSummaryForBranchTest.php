<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Project;

use Jmleroux\CircleCi\Api\Project\BuildSummaryForBranch;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class BuildSummaryForBranchTest extends TestCase
{
    use ExecuteWithRetryTrait;

    public function testQueryOk()
    {
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new Client($personalToken, 'v1.1');
        $query = new BuildSummaryForBranch($client);
        $builds = $this->executeWithRetry($query, ['github', 'jmleroux', 'circleci-php-client', 'master']);
        $this->assertIsArray($builds);

        $firstBuild = $builds[0];
        $this->assertIsObject($firstBuild->rawValues());
        $this->assertIsString($firstBuild->vcsUrl());
        $this->assertIsString($firstBuild->buildUrl());
        $this->assertIsInt($firstBuild->buildNum());
        $this->assertIsString($firstBuild->branch());
        $this->assertIsString($firstBuild->vcsRevision());
        $this->assertIsString($firstBuild->why());
        $this->assertNull($firstBuild->dontBuild());
        if (null !== $firstBuild->queuedAt()) {
            $this->assertInstanceOf(\DateTimeImmutable::class, $firstBuild->queuedAt());
        }
        if (null !== $firstBuild->startTime()) {
            $this->assertInstanceOf(\DateTimeImmutable::class, $firstBuild->startTime());
        }
        if (null !== $firstBuild->stopTime()) {
            $this->assertInstanceOf(\DateTimeImmutable::class, $firstBuild->stopTime());
        }
        $this->assertIsInt($firstBuild->buildTimeMillis());
        $this->assertIsString($firstBuild->username());
        $this->assertIsString($firstBuild->reponame());
        $this->assertIsString($firstBuild->lifecycle());
        if (null !== $firstBuild->outcome()) {
            $this->assertIsString($firstBuild->outcome());
        }
        $this->assertIsString($firstBuild->status());
    }

    public function testMaxResults()
    {
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new Client($personalToken, 'v1.1');
        $query = new BuildSummaryForBranch($client);
        $builds = $this->executeWithRetry($query, ['github', 'jmleroux', 'circleci-php-client', 'master', [], 2]);
        $this->assertCount(2, $builds);

        $builds = $query->execute('github', 'jmleroux', 'circleci-php-client', 'master', [], 8);
        $this->assertCount(8, $builds);

        $builds = $query->execute('github', 'jmleroux', 'circleci-php-client', 'master', ['limit' => 6], 8);
        $this->assertCount(8, $builds);
    }
}
