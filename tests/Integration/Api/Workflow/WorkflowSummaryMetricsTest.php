<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Workflow;

use Jmleroux\CircleCi\Api\Workflow\WorkflowRecentRuns;
use Jmleroux\CircleCi\Api\Workflow\WorkflowSummaryMetrics;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\WorkflowRun;
use PHPUnit\Framework\TestCase;

class WorkflowSummaryMetricsTest extends TestCase
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
        $query = new WorkflowSummaryMetrics($this->client);

        $summaryResults = $query->execute('gh/jmleroux/circleci-php-client', 'build_test');

        $this->assertIsArray($summaryResults);
//        $this->assertInstanceOf(WorkflowRun::class, $summaryResults[0]);

        $summaryResults = $query->execute('gh/jmleroux/circleci-php-client', 'unknown_workflow');

        $this->assertIsArray($summaryResults);
        $this->assertEmpty($summaryResults);
    }
}
