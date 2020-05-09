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
        $this->assertInstanceOf(JobRun::class, $recentRuns[0]);
        $this->assertIsString($recentRuns[0]->id());
        $this->assertIsString($recentRuns[0]->status());
        $this->assertIsInt($recentRuns[0]->duration());
        $this->assertInstanceOf(\DateTimeImmutable::class, $recentRuns[0]->startedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $recentRuns[0]->stoppedAt());

        $recentRuns = $query->execute('gh/jmleroux/circleci-php-client', 'build_test', 'unknown_job');

        $this->assertIsArray($recentRuns);
        $this->assertEmpty($recentRuns);
    }
}
