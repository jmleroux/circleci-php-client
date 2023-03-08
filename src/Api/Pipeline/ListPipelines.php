<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Pipeline;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Pipeline;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Returns all pipelines for the most recently built projects (max 250) you follow in an organization.
 *
 * @author     jmleroux <jmleroux.pro@gmail.com>
 * @link       https://circleci.com/docs/api/v2/index.html#operation/listPipelines
 */
class ListPipelines
{
    use ValidateClientVersionTrait;

    protected const endpointPattern = 'pipeline';

    public function __construct(private readonly Client $client)
    {
        $this->validateClientVersion($client, ['v2']);
    }

    /**
     * @return Pipeline[]
     */
    public function execute(string $orgSlug, ?bool $mine = false, ?int $maxPipelineCount = 250): array
    {
        $pipelines = [];

        $nextPageToken = null;
        $params = [
            'org-slug' => $orgSlug,
            'mine' => $mine,
        ];

        do {
            if (null !== $nextPageToken) {
                $params['page-token'] = $nextPageToken;
            }

            $response = json_decode($this->client->get(static::endpointPattern, $params)->getContent());
            $nextPageToken = $response->next_page_token;

            foreach ($response->items as $item) {
                $pipelines[] = Pipeline::createFromApi($item);
                if (count($pipelines) >= $maxPipelineCount) {
                    break;
                }
            }
        } while (null !== $nextPageToken && count($pipelines) < $maxPipelineCount);

        return $pipelines;
    }
}
