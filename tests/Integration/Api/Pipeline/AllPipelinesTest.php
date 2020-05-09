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
        $PERSONALToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($PERSONALToken, 'v2');
    }

    public function testQuery()
    {
        $query = new AllPipelines($this->client);

        $result = $query->execute('gh/jmleroux/circleci-php-client', null, null);

        $this->assertIsArray($result);
    }

    public function testQueryWithBranch()
    {
        $query = new AllPipelines($this->client);

        $pipelines = $query->execute('gh/jmleroux/circleci-php-client', null, 'master');

        $this->assertIsArray($pipelines);
        foreach ($pipelines as $pipeline) {
            $this->assertEquals('master', $pipeline->vcs()->branch);
        }
    }
}
