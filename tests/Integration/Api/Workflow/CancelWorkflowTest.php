<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Workflow;

use DateTimeInterface;
use GuzzleHttp\Exception\RequestException;
use Jmleroux\CircleCi\Api\Pipeline\AllPipelines;
use Jmleroux\CircleCi\Api\Pipeline\PipelineWorkflows;
use Jmleroux\CircleCi\Api\Workflow\CancelWorkflow;
use Jmleroux\CircleCi\Api\Workflow\SingleWorkflow;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Workflow;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class CancelWorkflowTest extends TestCase
{
    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $PERSONALToken = getenv('CIRCLECI_PERSONAL_TOKEN');
        $this->client = new Client($PERSONALToken, 'v2');
    }

    public function testQueryKo()
    {
        $this->expectException(RequestException::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage('{"message":"Workflow not found"}');

        $query = new CancelWorkflow($this->client);
        $query->execute('foobar');
    }
}
