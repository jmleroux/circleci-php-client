<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Pipeline;

use Jmleroux\CircleCi\Api\Pipeline\ListPipelines;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Pipeline;
use Jmleroux\CircleCi\Model\Pipeline\Vcs;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class ListPipelinesTest extends TestCase
{
    use ExecuteWithRetryTrait;

    private Client $client;

    public function setUp(): void
    {
        $personaltoken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($personaltoken, 'v2');
    }

    public function testQuery()
    {
        $query = new ListPipelines($this->client);

        $result = $this->executeWithRetry($query, ['gh/jmleroux']);

        $this->assertIsArray($result);
        $this->assertInstanceOf(Pipeline::class, $result[0]);
    }

    public function testMaxResults()
    {
        $query = new ListPipelines($this->client);

        $result = $this->executeWithRetry($query, ['gh/jmleroux', false, 50]);

        $this->assertIsArray($result);
        $this->assertCount(50, $result);
    }

    public function testPipelineModel()
    {
        $query = new ListPipelines($this->client);

        $result = $this->executeWithRetry($query, ['gh/jmleroux', true, 2]);

        /** @var Pipeline $pipeline */
        $pipeline = $result[0];

        $this->assertInstanceOf(Pipeline::class, $pipeline);
        $this->assertIsString($pipeline->id());
        $this->assertIsArray($pipeline->errors());
        $this->assertSame('gh/jmleroux/circleci-php-client', $pipeline->projectSlug());
        $this->assertInstanceOf(\DateTimeImmutable::class, $pipeline->updatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $pipeline->createdAt());
        $this->assertIsInt($pipeline->number());
        $this->assertIsString($pipeline->state());
        $this->assertNull($pipeline->triggerParameters());
        $this->assertInstanceOf(Pipeline\Trigger::class, $pipeline->trigger());
        $this->assertInstanceOf(Vcs::class, $pipeline->vcs());
    }
}
