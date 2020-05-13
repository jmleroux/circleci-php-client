<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api;

use Jmleroux\CircleCi\Api\BuildSummary;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class BuildSummaryTest extends TestCase
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
        $query = new BuildSummary($this->client);

        $build = $query->execute('github', 'jmleroux', 'circleci-php-client');

        $this->assertIsArray($build);
    }
}
