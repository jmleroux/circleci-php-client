<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Pipeline;

use Jmleroux\CircleCi\Api\Pipeline\AllPipelines;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Pipeline;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class AllPipelinesTest extends TestCase
{
    use ExecuteWithRetryTrait;

    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $personaltoken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($personaltoken, 'v2');
    }

    public function testQuery()
    {
        $query = new AllPipelines($this->client);

        $result = $this->executeWithRetry($query, ['gh/jmleroux/circleci-php-client', null, null]);

        $this->assertIsArray($result);
    }

    public function testQueryWithBranch()
    {
        $query = new AllPipelines($this->client);

        $pipelines = $this->executeWithRetry($query, ['gh/jmleroux/circleci-php-client', null, 'master']);

        $this->assertIsArray($pipelines);
        foreach ($pipelines as $pipeline) {
            $this->assertInstanceOf(Pipeline::class, $pipeline);
            $this->assertEquals('master', $pipeline->vcs()->branch);
        }
    }
}
