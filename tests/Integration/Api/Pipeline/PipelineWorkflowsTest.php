<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Pipeline;

use Jmleroux\CircleCi\Api\Pipeline\AllPipelines;
use Jmleroux\CircleCi\Api\Pipeline\PipelineWorkflows;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Workflow;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class PipelineWorkflowsTest extends TestCase
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
        $query = new AllPipelines($this->client);
        $pipelines = $this->executeWithRetry($query, ['gh/jmleroux/circleci-php-client', null, 'master']);
        $pipeline = $pipelines[0];

        $query = new PipelineWorkflows($this->client);
        $workflows = $this->executeWithRetry($query, [$pipeline->id()]);

        $this->assertIsArray($workflows);
        $this->assertInstanceOf(Workflow::class, $workflows[0]);
    }
}
