<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Job;

use Jmleroux\CircleCi\Api\Job\SingleBuild;
use Jmleroux\CircleCi\Model\JobDetails;
use Jmleroux\CircleCi\Tests\Integration\TestClient;
use Jmleroux\CircleCi\Tests\MockServer;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class SingleBuildTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        MockServer::startServer();
    }

    public function testQueryOk()
    {
        $personaltoken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new TestClient(MockServer::getServerRoot(), $personaltoken, 'v1.1');
        $query = new SingleBuild($client);
        $build = $query->execute('gh', 'jmleroux', 'my_project', 22);
        $this->assertInstanceOf(JobDetails::class, $build);
        $this->assertEquals(22, $build->buildNum());
    }
}
