<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Pipeline;

use Jmleroux\CircleCi\Api\Pipeline\AllPipelines;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;

class AllPipelinesTest extends TestCase
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

        $result = $query->execute('gh/jmleroux/circleci-php-client', null);

        $this->assertInstanceOf(\stdClass::class, $result);
    }

    public function testQueryWithBranch()
    {
        $query = new AllPipelines($this->client);

        $result = $query->execute('gh/jmleroux/circleci-php-client', 'master');

        $this->assertInstanceOf(\stdClass::class, $result);

        foreach ($result->items as $pipeline) {
            $this->assertEquals('master', $pipeline->vcs->branch);
        }
    }
}
