<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Unit\Api;

use Jmleroux\CircleCi\Api\SingleBuild;
use Jmleroux\CircleCi\Api\SingleWorkflow;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class SingleWorkflowTest extends TestCase
{
    public function testExecute()
    {
        $expectedString = file_get_contents(__DIR__ . '/../resources/workflow.json');
        $response = $this->createMock(ResponseInterface::class);
        $message = $this->createMock(StreamInterface::class);
        $response->method('getBody')
            ->willReturn($message);
        $message->method('__toString')
            ->willReturn($expectedString);

        $client = $this->createMock(Client::class, 'v2');
        $client->method('get')
            ->with('workflow/my_workflow_id')
            ->willReturn($response);

        $query = new SingleWorkflow($client);

        $build = $query->execute('my_workflow_id');

        $this->assertInstanceOf(\stdClass::class, $build);
        $this->assertEquals(json_decode($expectedString), $build);
    }
}
