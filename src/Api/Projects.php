<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Return all followed projects of the calling user.
 * This API needs a personnal access token
 *
 * @see    https://circleci.com/docs/api/#authentication
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link https://circleci.com/docs/api/#get-all-followed-projects
 */
class Projects
{
    use ValidateClientVersionTrait;

    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->validateClientVersion($client, ['v1.1']);
        $this->client = $client;
    }

    public function execute(): array
    {
        $uri = 'projects';

        $response = $this->client->get($uri);

        return json_decode((string)$response->getBody());
    }
}
