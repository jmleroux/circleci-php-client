<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Insights;

use Jmleroux\CircleCi\Api\Insights\ProjectSummary;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class ProjectSummaryTest extends TestCase
{
    use ExecuteWithRetryTrait;

    public function testQueryOk()
    {
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new Client($personalToken, 'v2');
        $query = new ProjectSummary($client);

        /** @var \Jmleroux\CircleCi\Model\ProjectSummary $summary */
        $summary = $this->executeWithRetry($query, ['github/jmleroux/circleci-php-client']);

        $this->assertIsObject($summary->rawValues());

        $this->assertIsString($summary->orgId());
        $this->assertIsString($summary->projectId());
        $this->assertIsObject($summary->projectData());
        $this->assertIsArray($summary->projectWorkflowData());
        $this->assertIsArray($summary->projectWorkflowBranchData());
        $this->assertIsArray($summary->allBranches());
        $this->assertIsArray($summary->allWorkflows());
    }
}
