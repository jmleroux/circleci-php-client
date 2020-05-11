<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api;

use Jmleroux\CircleCi\Api\BranchLastBuild;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class BranchBuildsTest extends TestCase
{
    public function testQueryOk()
    {
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new Client($personalToken);
        $query = new BranchLastBuild($client);
        $build = $query->execute('github', 'jmleroux', 'circleci-php-client', 'master');
        $this->assertInstanceOf(\stdClass::class, $build);
    }
}
