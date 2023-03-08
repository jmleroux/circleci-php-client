<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Workflow;

use Jmleroux\CircleCi\Api\Workflow\WorkflowRecentRuns;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\WorkflowRun;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\TestCase;

class WorkflowRecentRunsTest extends TestCase
{
    use ExecuteWithRetryTrait;

    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $PERSONALToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($PERSONALToken, 'v2');
    }

    public function testQuery()
    {
        $query = new WorkflowRecentRuns($this->client);

        $workflowRuns = $this->executeWithRetry(
            $query,
            ['gh/jmleroux/circleci-php-client', 'build_test', ['branch' => 'master']]
        );

        $this->assertIsArray($workflowRuns);
        $this->assertGreaterThanOrEqual(1, count($workflowRuns));
        $this->assertInstanceOf(WorkflowRun::class, $workflowRuns[0]);
        $this->assertIsString($workflowRuns[0]->id());
        $this->assertIsString($workflowRuns[0]->status());
        $this->assertIsInt($workflowRuns[0]->duration());
        $this->assertInstanceOf(\DateTimeImmutable::class, $workflowRuns[0]->createdAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $workflowRuns[0]->stoppedAt());

        $workflowRuns = $this->executeWithRetry(
            $query,
            ['gh/jmleroux/circleci-php-client', 'unknown_workflow']
        );

        $this->assertIsArray($workflowRuns);
        $this->assertEmpty($workflowRuns);
    }
}
