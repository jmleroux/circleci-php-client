<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api;

use Jmleroux\CircleCi\Api\BranchLastBuild;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;

class BranchBuildsTest extends TestCase
{
    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $PersonalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($PersonalToken);
    }

    public function testQueryOk()
    {
        $query = new BranchLastBuild($this->client);

        $builds = $query->execute('github', 'jmleroux', 'circleci-php-client', 'master');

        $this->assertInstanceOf(\stdClass::class, $builds);
    }
}
