<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Pipeline;

use Jmleroux\CircleCi\Api\Pipeline\AllPipelines;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Pipeline;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class AllPipelinesTest extends TestCase
{
    use ExecuteWithRetryTrait;

    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $personaltoken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($personaltoken, 'v2');
    }

    public function testQuery()
    {
        $query = new AllPipelines($this->client);

        $result = $this->executeWithRetry($query, ['gh/jmleroux/circleci-php-client', null, null]);

        $this->assertIsArray($result);
    }

    public function testPipelineModel()
    {
        $query = new AllPipelines($this->client);

        $result = $this->executeWithRetry($query, ['gh/jmleroux/circleci-php-client', null, null]);

        /** @var Pipeline $pipeline */
        $pipeline = $result[0];

        $this->assertInstanceOf(Pipeline::class, $pipeline);
        $this->assertIsString('7a89bb9e-565a-4964-9788-07fac5ae1355', $pipeline->id());
        $this->assertIsArray($pipeline->errors());
        $this->assertSame('gh/jmleroux/circleci-php-client', $pipeline->projectSlug());
        $this->assertInstanceOf(\DateTimeImmutable::class, $pipeline->updatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $pipeline->createdAt());
        $this->assertIsInt($pipeline->number());
        $this->assertSame('created', $pipeline->state());
    }

    public function testQueryWithBranch()
    {
        $query = new AllPipelines($this->client);

        $pipelines = $this->executeWithRetry($query, ['gh/jmleroux/circleci-php-client', null, 'master']);

        $this->assertIsArray($pipelines);
        foreach ($pipelines as $pipeline) {
            $this->assertInstanceOf(Pipeline::class, $pipeline);
            $this->assertEquals('master', $pipeline->vcs()->branch);
        }
    }
}
