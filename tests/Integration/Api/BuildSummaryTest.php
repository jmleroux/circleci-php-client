<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api;

use Jmleroux\CircleCi\Api\BuildSummary;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;

class BuildSummaryTest extends TestCase
{
    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $this->client = new Client('c900a267b73d8fbcab665fedc818c8de2b6aedf1');
    }

    public function testQueryOk()
    {
        $query = new BuildSummary($this->client);

        $build = $query->execute('github', 'jmleroux', 'circleci-php-client');

        $this->assertIsArray($build);
    }
}
