<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\V2\Pipeline;

use Jmleroux\CircleCi\Client;

/**
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

    public function execute(string $projectSlug, ?string $branch): ?\stdClass
    {
        $uri = sprintf('project/%s/pipeline', $projectSlug);

        $params = [];
        if (null !== $branch) {
            $params['branch'] = $branch;
        }

        $response = $this->client->get($uri, $params);

        return json_decode((string)$response->getBody());
    }
}
