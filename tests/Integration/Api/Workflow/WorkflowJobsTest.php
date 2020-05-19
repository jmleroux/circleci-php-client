<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Workflow;

use Jmleroux\CircleCi\Api\Workflow\WorkflowJobs;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Job;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class WorkflowJobsTest extends TestCase
{
    use ExecuteWithRetryTrait;

    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($personalToken, 'v2');
    }

    public function testQuery()
    {
        $query = new WorkflowJobs($this->client);
        $jobs = $this->executeWithRetry($query, ['78176b2f-c1e3-4c18-86e3-5a80a2f109bb']);
        Assert::assertIsArray($jobs);

        $firstJob = $jobs[0];
        Assert::assertInstanceOf(Job::class, $firstJob);
        Assert::assertIsString($firstJob->id());
        Assert::assertIsString($firstJob->name());
        Assert::assertIsString($firstJob->projectSlug());
        Assert::assertIsString($firstJob->type());
        Assert::assertIsString($firstJob->status());
        if (null !== $firstJob->approvedBy()) {
            Assert::assertIsString($firstJob->approvedBy());
        }
        if (null !== $firstJob->canceledBy()) {
            Assert::assertIsString($firstJob->canceledBy());
        }
        Assert::assertIsInt($firstJob->jobNumber());
        Assert::assertIsArray($firstJob->dependencies());
        Assert::assertInstanceOf(\DateTimeImmutable::class, $firstJob->startedAt());
        Assert::assertInstanceOf(\DateTimeImmutable::class, $firstJob->stoppedAt());
    }
}
