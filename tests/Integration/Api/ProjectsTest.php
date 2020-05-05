<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api;

use Jmleroux\CircleCi\Api\Projects;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;

class ProjectsTest extends TestCase
{
    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $PERSONALToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($PERSONALToken);
    }

    public function testQueryOk()
    {
        $query = new Projects($this->client);

        $projects = $query->execute();

        $this->assertIsArray($projects);
    }
}
