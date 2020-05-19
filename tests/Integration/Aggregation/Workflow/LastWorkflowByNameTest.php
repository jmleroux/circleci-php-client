<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Aggregation\Workflow;

use DateTimeInterface;
use Jmleroux\CircleCi\Aggregation\Workflow\LastWorkflowByName;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Workflow;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class LastWorkflowByNameTest extends TestCase
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
        $query = new LastWorkflowByName($this->client);

        $workflow = $this->executeWithRetry($query, ['gh/jmleroux/circleci-php-client', 'build_test', null]);

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

        $workflow = $this->executeWithRetry($query, ['gh/jmleroux/circleci-php-client', 'unknown_workflow', null]);
        Assert::assertNull($workflow);
    }
}
