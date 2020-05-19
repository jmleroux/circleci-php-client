<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Workflow;

use DateTimeInterface;
use Jmleroux\CircleCi\Api\Workflow\LastWorkflowByName;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Workflow;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class LastWorkflowByNameTest extends TestCase
{
    /** @var Client */
    private $client;

    public static function setUpBeforeClass(): void
    {
        sleep((int)$_ENV['TEST_DELAY_DURATION']);
    }

    public function setUp(): void
    {
        $PERSONALToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($PERSONALToken, 'v2');
    }

    public function testQuery()
    {
        $query = new LastWorkflowByName($this->client);

        $workflow = $query->execute('gh/jmleroux/circleci-php-client', 'build_test', null);

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

        $workflow = $query->execute('gh/jmleroux/circleci-php-client', 'unknown_workflow', null);
        Assert::assertNull($workflow);
    }
}
