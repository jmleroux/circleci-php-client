<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Project;

use Jmleroux\CircleCi\Api\Project\ProjectSummaryMetrics;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use Jmleroux\CircleCi\Tests\Integration\TestClient;
use Jmleroux\CircleCi\Tests\MockServer;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 *
 * @deprecated
 */
class ProjectSummaryMetricsTest extends TestCase
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
        $query = new ProjectSummaryMetrics($this->client);

        $summaryResults = $query->execute('gh/jmleroux/my_project');
        $this->assertIsArray($summaryResults);
        $this->assertCount(1, $summaryResults);
    }
}
