<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Project;

use Jmleroux\CircleCi\Api\Project\ProjectPipelines;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Pipeline;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use Jmleroux\CircleCi\Tests\Integration\TestClient;
use Jmleroux\CircleCi\Tests\MockServer;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class ProjectPipelinesTest extends TestCase
{
    use ExecuteWithRetryTrait;

    private Client $client;

    public function setUp(): void
    {
        MockServer::startServer();
        $personaltoken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new TestClient(MockServer::getServerRoot(), $personaltoken, 'v2');
    }

    public function testQuery()
    {
        $query = new ProjectPipelines($this->client);

        $result = $this->executeWithRetry($query, ['gh/jmleroux/my_project', null, null]);

        $this->assertIsArray($result);
    }

    public function testPipelineModel()
    {
        $query = new ProjectPipelines($this->client);

        $result = $this->executeWithRetry($query, ['gh/jmleroux/my_project', null, null]);

        /** @var Pipeline $pipeline */
        $pipeline = $result[0];

        $this->assertInstanceOf(Pipeline::class, $pipeline);
        $this->assertIsString($pipeline->id());
        $this->assertIsArray($pipeline->errors());
        $this->assertSame('gh/jmleroux/my_project', $pipeline->projectSlug());
        $this->assertInstanceOf(\DateTimeImmutable::class, $pipeline->updatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $pipeline->createdAt());
        $this->assertIsInt($pipeline->number());
        $this->assertSame('created', $pipeline->state());
    }

    public function testQueryWithBranch()
    {
        $query = new ProjectPipelines($this->client);

        $pipelines = $this->executeWithRetry($query, ['gh/jmleroux/my_project', null, 'master']);

        $this->assertIsArray($pipelines);
        foreach ($pipelines as $pipeline) {
            $this->assertInstanceOf(Pipeline::class, $pipeline);
            $this->assertEquals('feature/design-new-api', $pipeline->vcs()->branch());
        }
    }
}
