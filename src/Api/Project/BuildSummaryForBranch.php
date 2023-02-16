<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Project;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\BuildSummary;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link   https://circleci.com/docs/api/#recent-builds-for-a-single-project
 */
class BuildSummaryForBranch
{
    use ValidateClientVersionTrait;

    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->validateClientVersion($client, ['v1.1']);
        $this->client = $client;
    }

    /**
     * @return BuildSummary[]
     */
    public function execute(
        string $vcsType,
        string $username,
        string $reponame,
        string $branch,
        array $queryParameters = [],
        int $maxResults = 30
    ): array {
        $builds = [];
        $uri = sprintf('project/%s/%s/%s/tree/%s', $vcsType, $username, $reponame, $branch);
        $offset = 0;
        $queryParameters['limit'] = $queryParameters['limit'] ?? 30;

        do {
            if ($offset > 0) {
                $queryParameters['offset'] = $offset;
            }
            $response = $this->client->get($uri, $queryParameters);
            $items = (array) json_decode((string) $response->getContent());
            foreach ($items as $item) {
                $builds[] = BuildSummary::createFromApi($item);
                if (count($builds) === $maxResults) {
                    break;
                }
            }
            $offset += $queryParameters['limit'];
        } while (!empty($items) && count($builds) < $maxResults);

        return $builds;
    }
}
