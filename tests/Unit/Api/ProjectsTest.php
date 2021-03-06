<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Unit\Api;

use Jmleroux\CircleCi\Api\Projects;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ProjectsTest extends TestCase
{
    public function testExecute()
    {
        $expectedString = file_get_contents(__DIR__ . '/../resources/projects.json');
        $response = $this->createMock(ResponseInterface::class);
        $message = $this->createMock(StreamInterface::class);
        $response->method('getBody')
            ->willReturn($message);
        $message->method('__toString')
            ->willReturn($expectedString);

        $client = $this->createMock(Client::class);
        $client->method('get')
            ->with('projects')
            ->willReturn($response);
        $client->method('getVersion')
            ->willReturn('v1.1');

        $query = new Projects($client);

        $projects = $query->execute();

        $this->assertIsArray($projects);
        $this->assertCount(2, $projects);
        $this->assertEquals(json_decode($expectedString), $projects);

        $project = $projects[1];
        $this->assertEquals('foobar', $project->reponame);
        $this->assertInstanceOf(\stdClass::class, $project->branches->master);
        $this->assertFalse(isset($project->branches->foo));
    }
}
