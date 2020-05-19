<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Workflow;

use DateTimeInterface;
use Jmleroux\CircleCi\Api\Pipeline\AllPipelines;
use Jmleroux\CircleCi\Api\Pipeline\PipelineWorkflows;
use Jmleroux\CircleCi\Api\Workflow\SingleWorkflow;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Workflow;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class SingleWorkflowTest extends TestCase
{
    use ExecuteWithRetryTrait;

    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($personalToken, 'v2');
    }

    public function testQuery()
    {
        $query = new AllPipelines($this->client);
        $pipelines = $this->executeWithRetry($query, ['gh/jmleroux/circleci-php-client', null, 'master']);
        $pipeline = $pipelines[0];

        $query = new PipelineWorkflows($this->client);
        $workflows = $this->executeWithRetry($query, [$pipeline->id()]);
        $workflow = $workflows[0];

        $query = new SingleWorkflow($this->client);
        $workflow = $this->executeWithRetry($query, [$workflow->id()]);

        Assert::assertInstanceOf(Workflow::class, $workflow);
        Assert::assertRegExp('/[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}/', $workflow->id());
        Assert::assertEquals('build_test', $workflow->name());
        Assert::assertTrue(
            in_array($workflow->status(), ['success', 'failed', 'running'], true),
            sprintf('Status %s is unknown', $workflow->status())
        );
        Assert::assertInstanceOf(DateTimeInterface::class, $workflow->createdAt());
        Assert::assertRegExp('/[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}/', $workflow->pipelineId());
        Assert::assertIsNumeric($workflow->pipelineNumber());
        Assert::assertEquals('gh/jmleroux/circleci-php-client', $workflow->projectSlug());
    }
}
