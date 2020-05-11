<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Workflow;

use Jmleroux\CircleCi\Api\Workflow\JobRecentRuns;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\JobRun;
use PHPUnit\Framework\TestCase;

class JobRecentRunsTest extends TestCase
{
    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $PERSONALToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($PERSONALToken, 'v2');
    }

    public function testQuery()
    {
        $query = new JobRecentRuns($this->client);

        $recentRuns = $query->execute('gh/jmleroux/circleci-php-client', 'build_test', 'tests');
        $this->assertIsArray($recentRuns);

        $firstRun = $recentRuns[0];
        $this->assertInstanceOf(JobRun::class, $firstRun);
        $this->assertIsObject($firstRun->rawValues());
        $this->assertIsString($firstRun->id());
        $this->assertIsString($firstRun->status());
        $this->assertIsInt($firstRun->duration());
        $this->assertInstanceOf(\DateTimeImmutable::class, $firstRun->startedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $firstRun->stoppedAt());

        $recentRuns = $query->execute('gh/jmleroux/circleci-php-client', 'build_test', 'unknown_job');

        $this->assertIsArray($recentRuns);
        $this->assertEmpty($recentRuns);
    }
}
