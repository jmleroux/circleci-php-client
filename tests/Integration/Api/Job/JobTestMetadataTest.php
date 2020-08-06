<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Job;

use Jmleroux\CircleCi\Api\Job\JobTestMetadata;
use Jmleroux\CircleCi\Model\TestMetadata;
use Jmleroux\CircleCi\Tests\Integration\TestClient;
use Jmleroux\CircleCi\Tests\MockServer;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class JobTestMetadataTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        MockServer::startServer();
    }

    public function testApiVersion()
    {
        $personaltoken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new TestClient(MockServer::getServerRoot(), $personaltoken, 'v1.1');
    }

    public function testQueryOk()
    {
        $personaltoken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new TestClient(MockServer::getServerRoot(), $personaltoken, 'v2');
        $query = new JobTestMetadata($client);
        $metadata = $query->execute('gh/jmleroux/my_project', 666);
        $this->assertIsArray($metadata);

        $firstObject = $metadata[0];
        $this->assertInstanceOf(TestMetadata::class, $firstObject);
    }
}
