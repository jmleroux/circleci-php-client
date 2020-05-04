<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Pipeline;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\Pipeline;

/**
 * Retrieve pipelines of a project, optionally filtered by branch.
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class AllPipelines
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function execute(string $projectSlug, ?string $branch): array
    {
        $pipelines = [];

        $uri = sprintf('project/%s/pipeline', $projectSlug);

        $params = [];
        if (null !== $branch) {
            $params['branch'] = $branch;
        }

        $rawResponse = $this->client->get($uri, $params);

        $response = json_decode((string)$response->getBody());

        foreach ($response->items as $item) {
            $pipelines[] = Pipeline::createFromApi($item);
        }

        return $pipelines;
    }
}
