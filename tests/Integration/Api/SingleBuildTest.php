<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api;

use Jmleroux\CircleCi\Api\SingleBuild;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class SingleBuildTest extends TestCase
{
    use ExecuteWithRetryTrait;

    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $personaltoken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($personaltoken);
    }

    public function testQueryOk()
    {
        $query = new SingleBuild($this->client);

        $build = $this->executeWithRetry($query, ['github', 'jmleroux', 'circleci-php-client', 50]);

        $this->assertInstanceOf(\stdClass::class, $build);
        $this->assertEquals(50, $build->build_num);
    }
}
