<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Pipeline;

use Jmleroux\CircleCi\Api\Pipeline\AllPipelines;
use Jmleroux\CircleCi\Api\Pipeline\PipelineWorkflows;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Workflow;
use PHPUnit\Framework\TestCase;

class PipelineWorkflowsTest extends TestCase
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
        $query = new AllPipelines($this->client);
        $pipelines = $query->execute('gh/jmleroux/circleci-php-client', null, 'master');
        $pipeline = $pipelines[0];

        $query = new PipelineWorkflows($this->client);
        $workflows = $query->execute($pipeline->id());

        $this->assertIsArray($workflows);
        $this->assertInstanceOf(Workflow::class, $workflows[0]);
    }
}
