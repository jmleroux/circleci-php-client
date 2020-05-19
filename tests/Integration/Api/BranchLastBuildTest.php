<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api;

use Jmleroux\CircleCi\Api\BranchLastBuild;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class BranchLastBuildTest extends TestCase
{
    use ExecuteWithRetryTrait;

    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($personalToken);
    }

    public function testQueryOk()
    {
        $query = new BranchLastBuild($this->client);

        $build = $this->executeWithRetry($query, ['github', 'jmleroux', 'circleci-php-client', 'master']);

        $this->assertInstanceOf(\stdClass::class, $build);
        $this->assertSame('master', $build->branch);
    }

    public function testQueryUnknownBranch()
    {
        $query = new BranchLastBuild($this->client);

        $build = $this->executeWithRetry($query, ['github', 'jmleroux', 'circleci-php-client', 'unknown_branch']);

        $this->assertEmpty($build);
    }
}
