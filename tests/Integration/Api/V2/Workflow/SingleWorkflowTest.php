<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\V2\Workflow;

use Jmleroux\CircleCi\Api\V2\Pipeline\AllPipelines;
use Jmleroux\CircleCi\Api\V2\Pipeline\PipelineWorkflows;
use Jmleroux\CircleCi\Api\V2\Workflow\SingleWorkflow;
use Jmleroux\CircleCi\Client;
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
        $result = $query->execute('gh/jmleroux/circleci-php-client', 'master');
        $pipeline = $result->items[0];

        $query = new PipelineWorkflows($this->client);
        $result = $query->execute($pipeline->id);
        $workflow = $result->items[0];

        $query = new SingleWorkflow($this->client);
        $result = $query->execute($workflow->id);

        $this->assertInstanceOf(\stdClass::class, $result);
    }
}
