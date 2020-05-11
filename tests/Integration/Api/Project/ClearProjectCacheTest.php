<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Project;

use Jmleroux\CircleCi\Api\Project\ClearProjectCache;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;

class ClearProjectCacheTest extends TestCase
{
    public function testQueryOk()
    {
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new Client($personalToken, 'v1.1');
        $query = new ClearProjectCache($client);
        $result = $query->execute('github', 'jmleroux', 'circleci-php-client');
        $this->assertIsString($result);
        $this->assertEquals('build dependency caches deleted', $result);
    }
}
