<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Workflow;

use DateTimeImmutable;
use Jmleroux\CircleCi\Api\Workflow\WorkflowSummaryMetrics;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\DurationMetrics;
use Jmleroux\CircleCi\Model\JobMetrics;
use Jmleroux\CircleCi\Model\JobSummaryResult;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use Jmleroux\CircleCi\Tests\Integration\TestClient;
use Jmleroux\CircleCi\Tests\MockServer;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class WorkflowSummaryMetricsTest extends TestCase
{
    use ExecuteWithRetryTrait;

    private Client $client;

    public function setUp(): void
    {
        MockServer::startServer();
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new TestClient(MockServer::getServerRoot(), $personalToken, 'v2');
    }

    public function testQuery()
    {
        $query = new WorkflowSummaryMetrics($this->client);

        $summaryResults = $query->execute('gh/jmleroux/my_project', 'my_workflow_name');
        $this->assertIsArray($summaryResults);
        $this->assertCount(2, $summaryResults);
        $this->assertSame('job-summary-1', $summaryResults[0]->name());
        $this->assertSame('job-summary-2', $summaryResults[1]->name());

        $firstResult = $summaryResults[0];
        $this->assertInstanceOf(JobSummaryResult::class, $firstResult);
        $this->assertIsString($firstResult->name());
        $this->assertInstanceOf(DateTimeImmutable::class, $firstResult->windowStart());
        $this->assertInstanceOf(DateTimeImmutable::class, $firstResult->windowEnd());

        $metrics = $firstResult->metrics();
        $this->assertInstanceOf(JobMetrics::class, $metrics);
        $this->assertIsFloat($metrics->successRate());
        $this->assertIsInt($metrics->totalRuns());
        $this->assertIsInt($metrics->failedRuns());
        $this->assertIsInt($metrics->successfulRuns());
        $this->assertIsFloat($metrics->throughput());

        $durationsMetrics = $metrics->durationsMetrics();
        $this->assertInstanceOf(DurationMetrics::class, $durationsMetrics);
        $this->assertIsInt($durationsMetrics->min());
        $this->assertIsInt($durationsMetrics->mean());
        $this->assertIsInt($durationsMetrics->median());
        $this->assertIsInt($durationsMetrics->p95());
        $this->assertIsInt($durationsMetrics->max());
        $this->assertIsFloat($durationsMetrics->standardDeviation());
    }

    public function testQueryMaxResults()
    {
        $query = new WorkflowSummaryMetrics($this->client);

        $summaryResults = $query->execute('gh/jmleroux/my_project', 'my_workflow_name', [], 1);
        $this->assertIsArray($summaryResults);
        $this->assertCount(1, $summaryResults);
        $this->assertSame('job-summary-1', $summaryResults[0]->name());
    }

    public function testQueryUnknownWorkflow()
    {
        $personnalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new Client($personnalToken, 'v2');

        $query = new WorkflowSummaryMetrics($client);

        $summaryResults = $query->execute('gh/jmleroux/circleci-php-client', 'unknown_workflow');
        $this->assertIsArray($summaryResults);
        $this->assertEmpty($summaryResults);
    }
}
