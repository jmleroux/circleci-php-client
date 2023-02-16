<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Job;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\Model\TestMetadata;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Get a job test metadata
 * Returns a sequence of test metadata for a job
 *
 * @author Benoit Jacquemont <benoit@akeneo.com>
 * @link https://circleci.com/docs/api/v2/#get-test-metadata
 */
class JobTestMetadata
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
     * @return TestMetadata[]
     */
    public function execute(string $projectSlug, int $jobNumber): array
    {
        $testMetadata = [];
        $uri = sprintf('project/%s/%s/tests', $projectSlug, $jobNumber);
        $params = [];

        $nextPageToken = null;
        do {
            if (null !== $nextPageToken) {
                $params['page-token'] = $nextPageToken;
            }

            $response = json_decode((string) $this->client->get($uri, $params)->getContent());
            $nextPageToken = $response->next_page_token;

            foreach ($response->items as $item) {
                $testMetadata[] = TestMetadata::createFromApi($item);
            }
        } while (null !== $nextPageToken);

        return $testMetadata;
    }
}
