<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Project;

use Jmleroux\CircleCi\Api\Project\BuildSummaryForBranch;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class BuildSummaryForBranchTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        sleep((int)$_ENV['TEST_DELAY_DURATION']);
    }

    public function testQueryOk()
    {
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new Client($personalToken, 'v1.1');
        $query = new BuildSummaryForBranch($client);
        $builds = $query->execute('github', 'jmleroux', 'circleci-php-client', 'master');
        $this->assertIsArray($builds);

        $firstBuild = $builds[0];
        $this->assertIsObject($firstBuild->rawValues());
        $this->assertIsString($firstBuild->vcsUrl());
        $this->assertIsString($firstBuild->buildUrl());
        $this->assertIsInt($firstBuild->buildNum());
        $this->assertIsString($firstBuild->branch());
        $this->assertIsString($firstBuild->vcsRevision());
        $this->assertIsString($firstBuild->committerName());
        $this->assertIsString($firstBuild->committerEmail());
        $this->assertIsString($firstBuild->body());
        $this->assertIsString($firstBuild->why());
        $this->assertNull($firstBuild->dontBuild());
        $this->assertInstanceOf(\DateTimeImmutable::class, $firstBuild->queuedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $firstBuild->startTime());
        $this->assertInstanceOf(\DateTimeImmutable::class, $firstBuild->stopTime());
        $this->assertIsInt($firstBuild->buildTimeMillis());
        $this->assertIsString($firstBuild->username());
        $this->assertIsString($firstBuild->reponame());
        $this->assertIsString($firstBuild->lifecycle());
        $this->assertIsString($firstBuild->outcome());
        $this->assertIsString($firstBuild->status());
    }

    public function testMaxResults()
    {
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new Client($personalToken, 'v1.1');
        $query = new BuildSummaryForBranch($client);
        $builds = $query->execute('github', 'jmleroux', 'circleci-php-client', 'master', [], 8);
        $this->assertCount(8, $builds);

        $builds = $query->execute('github', 'jmleroux', 'circleci-php-client', 'master', [], 50);
        $this->assertCount(50, $builds);

        $builds = $query->execute('github', 'jmleroux', 'circleci-php-client', 'master', ['limit' => 6], 22);
        $this->assertCount(22, $builds);
    }
}
