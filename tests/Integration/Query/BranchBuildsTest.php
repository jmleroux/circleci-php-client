<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Query;

use Jmleroux\CircleCi\Model\Job;
use PHPUnit\Framework\TestCase;

class BranchBuildsTest extends TestCase
{
    public function testQueryOk()
    {
        require dirname(__DIR__) . '/../../vendor/autoload.php';

        $query = new \Jmleroux\CircleCi\Query\BranchBuilds(
            'c900a267b73d8fbcab665fedc818c8de2b6aedf1',
            'github',
            'jmleroux',
            'circleci-php-client'
        );

        $builds = $query->execute('master');

        $this->assertContainsOnly(Job::class, $builds);
    }
}
