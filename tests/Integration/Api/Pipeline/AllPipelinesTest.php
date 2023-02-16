<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Pipeline;

use Jmleroux\CircleCi\Api\Pipeline\AllPipelines;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Pipeline;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use Jmleroux\CircleCi\Tests\Integration\TestClient;
use Jmleroux\CircleCi\Tests\MockServer;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class AllPipelinesTest extends TestCase
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
        $query = new AllPipelines($this->client);

        $result = $this->executeWithRetry($query, ['gh/jmleroux/my_project', null, null]);

        $this->assertIsArray($result);
    }

    public function testPipelineModel()
    {
        $query = new AllPipelines($this->client);

        $result = $this->executeWithRetry($query, ['gh/jmleroux/my_project', null, null]);

        /** @var Pipeline $pipeline */
        $pipeline = $result[0];

        $this->assertInstanceOf(Pipeline::class, $pipeline);
        $this->assertIsString('7a89bb9e-565a-4964-9788-07fac5ae1355', $pipeline->id());
        $this->assertIsArray($pipeline->errors());
        $this->assertSame('gh/jmleroux/my_project', $pipeline->projectSlug());
        $this->assertInstanceOf(\DateTimeImmutable::class, $pipeline->updatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $pipeline->createdAt());
        $this->assertIsInt($pipeline->number());
        $this->assertSame('created', $pipeline->state());
    }

    public function testQueryWithBranch()
    {
        $query = new AllPipelines($this->client);

        $pipelines = $this->executeWithRetry($query, ['gh/jmleroux/my_project', null, 'master']);

        $this->assertIsArray($pipelines);
        foreach ($pipelines as $pipeline) {
            $this->assertInstanceOf(Pipeline::class, $pipeline);
            $this->assertEquals('feature/design-new-api', $pipeline->vcs()->branch());
        }
    }
}
