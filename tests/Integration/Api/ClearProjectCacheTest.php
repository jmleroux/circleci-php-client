<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api;

use Jmleroux\CircleCi\Api\ClearProjectCache;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class ClearProjectCacheTest extends TestCase
{
    use ExecuteWithRetryTrait;

    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $PERSONALToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($PERSONALToken);
    }

    public function testQueryOk()
    {
        $query = new ClearProjectCache($this->client);

        $result = $this->executeWithRetry($query, ['github', 'jmleroux', 'circleci-php-client']);

        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals('build dependency caches deleted', $result->status);
    }
}
