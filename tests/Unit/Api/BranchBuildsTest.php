<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Unit\Api;

use Jmleroux\CircleCi\Api\BranchBuilds;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class BranchBuildsTest extends TestCase
{
    public function testExecute()
    {
        $expectedString = file_get_contents(__DIR__ . '/../resources/recent_builds.json');
        $response = $this->createMock(ResponseInterface::class);
        $message = $this->createMock(StreamInterface::class);
        $response->method('getBody')
            ->willReturn($message);
        $message->method('__toString')
            ->willReturn($expectedString);

        $client = $this->createMock(Client::class);
        $client->method('get')
            ->with('project/github/my_username/my_reponame/tree/my_branch')
            ->willReturn($response);
        $client->method('getVersion')
            ->willReturn('v1.1');

        $query = new BranchBuilds($client);

        $builds = $query->execute('github', 'my_username', 'my_reponame', 'my_branch');

        $this->assertIsArray($builds);
        $this->assertCount(2, $builds);
        $this->assertEquals(json_decode($expectedString), $builds);
    }
}
