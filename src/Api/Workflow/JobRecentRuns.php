<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Workflow;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Get recent runs of a workflow job
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link   https://circleci.com/docs/api/v2/#get-recent-runs-of-a-workflow
 */
class JobRecentRuns
{
    use ValidateClientVersionTrait;

    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->validateClientVersion($client, ['v2']);
        $this->client = $client;
    }

    public function execute(
        string $projectSlug,
        string $workflowName,
        string $jobName,
        array $queryParameters = []
    ): ?\stdClass {
        $uri = sprintf('insights/%s/workflows/%s/jobs/%s', $projectSlug, $workflowName, $jobName);
        $response = $this->client->get($uri, $queryParameters);

        return json_decode((string) $response->getBody());
    }
}
