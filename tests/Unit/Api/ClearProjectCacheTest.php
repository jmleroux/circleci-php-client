<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Unit\Api;

use Jmleroux\CircleCi\Api\BranchBuilds;
use Jmleroux\CircleCi\Api\ClearProjectCache;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ClearProjectCacheTest extends TestCase
{
    public function testExecute()
    {
        $expectedString = '{"status": "build dependency caches deleted"}';
        $response = $this->createMock(ResponseInterface::class);
        $message = $this->createMock(StreamInterface::class);
        $response->method('getBody')
            ->willReturn($message);
        $message->method('__toString')
            ->willReturn($expectedString);

        $client = $this->createMock(Client::class);
        $client->method('delete')
            ->with('project/github/my_username/my_reponame/build-cache')
            ->willReturn($response);

        $query = new ClearProjectCache($client);

        $result = $query->execute('github', 'my_username', 'my_reponame');

        $this->assertEquals(json_decode($expectedString), $result);
    }
}
