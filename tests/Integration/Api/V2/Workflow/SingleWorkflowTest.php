<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\V2\Workflow;

use Jmleroux\CircleCi\Api\V2\Pipeline\AllPipelines;
use Jmleroux\CircleCi\Api\V2\Pipeline\PipelineWorkflows;
use Jmleroux\CircleCi\Api\V2\Workflow\SingleWorkflow;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Workflow;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class SingleWorkflowTest extends TestCase
{
    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $this->client = new Client('c12be1379ca68b91d314ff3b44de7b7555b3c652', 'v2');
    }

    public function testQuery()
    {
        $query = new AllPipelines($this->client);
        $workflow = $query->execute('gh/jmleroux/circleci-php-client', 'master');
        $pipeline = $workflow->items[0];

        $query = new PipelineWorkflows($this->client);
        $workflow = $query->execute($pipeline->id);
        $workflow = $workflow->items[0];

        $query = new SingleWorkflow($this->client);
        $workflow = $query->execute($workflow->id);

        Assert::assertInstanceOf(Workflow::class, $workflow);
        Assert::assertRegExp('/[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}/', $workflow->id());
        Assert::assertEquals('build_test', $workflow->name());
        Assert::assertTrue(in_array($workflow->status(), ['success'], true));
        Assert::assertInstanceOf(\DateTimeInterface::class, $workflow->createdAt());
        Assert::assertInstanceOf(\DateTimeInterface::class, $workflow->stoppedAt());
        Assert::assertRegExp('/[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}/', $workflow->pipelineId());
        Assert::assertIsNumeric($workflow->pipelineNumber());
        Assert::assertEquals('gh/jmleroux/circleci-php-client', $workflow->projectSlug());
    }
}
