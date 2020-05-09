<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Workflow;

use Jmleroux\CircleCi\Api\Workflow\WorkflowRecentRuns;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class WorkflowRecentRunsTest extends TestCase
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
        $query = new WorkflowRecentRuns($this->client);

        $result = $query->execute('gh/jmleroux/circleci-php-client', 'build_test', ['branch' => 'master']);

        $this->assertInstanceOf(\stdClass::class, $result);
        Assert::assertIsArray($result->items);

        $result = $query->execute('gh/jmleroux/circleci-php-client', 'unknown_workflow');
        $expected = new \stdClass();
        $expected->next_page_token = null;
        $expected->items = [];

        Assert::assertEquals($expected, $result);
    }
}
