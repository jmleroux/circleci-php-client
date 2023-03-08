<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Project;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Pipeline;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Retrieve pipelines of a project, optionally filtered by branch.
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link   https://circleci.com/docs/api/v2/#operation/listPipelinesForProject
 */
class ProjectPipelines
{
    use ValidateClientVersionTrait;

    public function __construct(private readonly Client $client)
    {
        $this->validateClientVersion($client, ['v2']);
    }

    /**
     * @return Pipeline[]
     */
    public function execute(string $projectSlug, ?int $maxPipelineCount = null, ?string $branch = null): array
    {
        $pipelines = [];

        $uri = sprintf('project/%s/pipeline', $projectSlug);
        $params = [];
        if (null !== $branch) {
            $params['branch'] = $branch;
        }

        $nextPageToken = null;
        $smallestPipelineNumber = PHP_INT_MAX;
        if (null === $maxPipelineCount) {
            $maxPipelineCount = PHP_INT_MAX;
        }

        do {
            if (null !== $nextPageToken) {
                $params['page-token'] = $nextPageToken;
                unset($params['branch']);
            }

            $response = json_decode((string)$this->client->get($uri, $params)->getContent());
            $nextPageToken = $response->next_page_token;

            foreach ($response->items as $item) {
                $pipeline = Pipeline::createFromApi($item);
                $lastPipelineNumber = $pipeline->number();
                $smallestPipelineNumber = min($lastPipelineNumber, $smallestPipelineNumber);
                $pipelines[] = Pipeline::createFromApi($item);
            }
        } while (null !== $nextPageToken && count($pipelines) < $maxPipelineCount);

        return $pipelines;
    }
}
