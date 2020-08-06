<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Pipeline;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Pipeline;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Retrieve pipelines of a project, optionally filtered by branch.
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link https://circleci.com/docs/api/v2/#get-all-pipelines
 */
class AllPipelines
{
    use ValidateClientVersionTrait;

    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->validateClientVersion($client, ['v2']);
        $this->client = $client;
    }

    /**
     * @return Pipeline[]
     */
    public function execute(string $projectSlug, ?int $maxPipelineCount, ?string $branch): array
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

            $response = json_decode((string) $this->client->get($uri, $params)->getBody());
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
