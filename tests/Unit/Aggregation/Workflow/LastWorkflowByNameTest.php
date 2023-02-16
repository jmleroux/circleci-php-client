<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Unit\Aggregation\Workflow;

use Jmleroux\CircleCi\Aggregation\Workflow\LastWorkflowByName;
use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Workflow;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;

class LastWorkflowByNameTest extends TestCase
{
    public function testExecute()
    {
        $recentsRuns = file_get_contents(__DIR__ . '/../../resources/workflow_recents_runs.json');
        $recentsRunsResponse = $this->createMock(ResponseInterface::class);
        $recentsRunsResponse->method('getContent')
            ->willReturn($recentsRuns);

        $singleWorkflow = file_get_contents(__DIR__ . '/../../resources/workflow.json');
        $singleWorkflowResponse = $this->createMock(ResponseInterface::class);
        $singleWorkflowResponse->method('getContent')
            ->willReturn($singleWorkflow);

        $client = $this->createMock(Client::class);
        $client->method('getVersion')
            ->willReturn('v2');
        $client->expects($this->exactly(2))->method('get')
            ->withConsecutive(
                ['insights/github/repo/workflows/my_workflow', ['branch' => 'my_branch']],
                ['workflow/878124b0-0933-4bd6-bcc4-c017238592c9']
            )
            ->willReturnOnConsecutiveCalls(
                $recentsRunsResponse,
                $singleWorkflowResponse
            );

        $query = new LastWorkflowByName($client);

        $result = $query->execute('github/repo', 'my_workflow', 'my_branch');

        $this->assertEquals(
            Workflow::createFromApi(json_decode($singleWorkflow)),
            $result
        );
    }
}
