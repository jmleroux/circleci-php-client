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

    public static function setUpBeforeClass(): void
    {
        sleep(1);
    }

    public function setUp(): void
    {
        $personaltoken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($personaltoken, 'v2');
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
