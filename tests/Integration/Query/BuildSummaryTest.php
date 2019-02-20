<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Query;

use Jmleroux\CircleCi\Model\Job;
use PHPUnit\Framework\TestCase;

class BuildSummaryTest extends TestCase
{
    public function testQueryOk()
    {
        require dirname(__DIR__) . '/../../vendor/autoload.php';

        $query = new \Jmleroux\CircleCi\Query\BuildSummary(
            'c900a267b73d8fbcab665fedc818c8de2b6aedf1',
            'github',
            'jmleroux',
            'circleci-php-client'
        );

        $build = $query->execute();

        $this->assertContainsOnly(Job::class, $build);
    }
}
