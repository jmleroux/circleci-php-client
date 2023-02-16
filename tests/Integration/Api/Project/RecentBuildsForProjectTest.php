<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Project;

use Jmleroux\CircleCi\Api\Project\RecentBuildsForProject;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class RecentBuildsForProjectTest extends TestCase
{
    use ExecuteWithRetryTrait;

    public function testQueryOk()
    {
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new Client($personalToken, 'v1.1');
        $query = new RecentBuildsForProject($client);
        $builds = $this->executeWithRetry($query, ['github', 'jmleroux', 'circleci-php-client']);
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
        $this->assertIsString($firstBuild->subject());
        $this->assertIsString($firstBuild->body());
        $this->assertIsString($firstBuild->why());
        $this->assertNull($firstBuild->dontBuild());
        $this->assertInstanceOf(\DateTimeImmutable::class, $firstBuild->queuedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $firstBuild->startTime());
        if (null !== $firstBuild->stopTime()) {
            $this->assertInstanceOf(\DateTimeImmutable::class, $firstBuild->stopTime());
            $this->assertIsInt($firstBuild->buildTimeMillis());
            $this->assertIsString($firstBuild->outcome());
        } else {
            $this->assertNull($firstBuild->stopTime());
            $this->assertEquals(0, $firstBuild->buildTimeMillis());
            $this->assertNull($firstBuild->outcome());
        }
        $this->assertIsString($firstBuild->username());
        $this->assertIsString($firstBuild->reponame());
        $this->assertIsString($firstBuild->lifecycle());
        $this->assertIsString($firstBuild->status());
    }

    public function testMaxResults()
    {
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new Client($personalToken, 'v1.1');
        $query = new RecentBuildsForProject($client);
        $builds = $this->executeWithRetry($query, ['github', 'jmleroux', 'circleci-php-client', [], 5]);
        $this->assertCount(5, $builds);

        $builds = $query->execute('github', 'jmleroux', 'circleci-php-client', [], 10);
        $this->assertCount(10, $builds);

        $builds = $query->execute('github', 'jmleroux', 'circleci-php-client', ['limit' => 5], 8);
        $this->assertCount(8, $builds);
    }
}
