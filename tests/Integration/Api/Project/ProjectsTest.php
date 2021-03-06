<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Project;

use Jmleroux\CircleCi\Api\Project\Projects;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Project;
use Jmleroux\CircleCi\Tests\Integration\ExecuteWithRetryTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class ProjectsTest extends TestCase
{
    use ExecuteWithRetryTrait;

    public function testQueryOk()
    {
        $personalToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $client = new Client($personalToken, 'v1.1');
        $query = new Projects($client);
        $projects = $this->executeWithRetry($query, []);
        $this->assertIsArray($projects);

        $firstProject = $projects[0];
        $this->assertInstanceOf(Project::class, $firstProject);
        $this->assertIsString($firstProject->vcsUrl());
        $this->assertIsBool($firstProject->followed());
        $this->assertIsString($firstProject->username());
        $this->assertIsString($firstProject->reponame());
        $this->assertIsObject($firstProject->branches());
    }
}
