<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Workflow;

use Jmleroux\CircleCi\Api\Workflow\JobRecentRuns;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\JobRun;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\TestCase;

class JobRecentRunsTest extends TestCase
{
    use ExecuteWithRetryTrait;

    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($personalToken, 'v2');
    }

    public function testQuery()
    {
        $query = new JobRecentRuns($this->client);

        $recentRuns = $this->executeWithRetry($query, ['gh/jmleroux/circleci-php-client', 'build_test', 'tests']);
        $this->assertIsArray($recentRuns);
        $this->assertGreaterThanOrEqual(1, count($recentRuns));

        $firstRun = $recentRuns[0];
        $this->assertInstanceOf(JobRun::class, $firstRun);
        $this->assertIsObject($firstRun->rawValues());
        $this->assertIsString($firstRun->id());
        $this->assertIsString($firstRun->status());
        $this->assertIsInt($firstRun->duration());
        $this->assertInstanceOf(\DateTimeImmutable::class, $firstRun->startedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $firstRun->stoppedAt());

        $recentRuns = $this->executeWithRetry($query, ['gh/jmleroux/circleci-php-client', 'build_test', 'unknown_job']);

        $this->assertIsArray($recentRuns);
        $this->assertEmpty($recentRuns);
    }
}
