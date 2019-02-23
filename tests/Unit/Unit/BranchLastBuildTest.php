<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Unit\Api;

use Jmleroux\CircleCi\Api\BranchLastBuild;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class BranchLastBuildTest extends TestCase
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

        $query = new BranchLastBuild($client);

        $build = $query->execute('github', 'my_username', 'my_reponame', 'my_branch');

        $this->assertInstanceOf(\stdClass::class, $build);
        $this->assertEquals(json_decode($expectedString)[0], $build);
    }
}
