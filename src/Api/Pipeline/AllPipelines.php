<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api\Pipeline;

use Jmleroux\CircleCi\Api\Project\ProjectPipelines;
use Jmleroux\CircleCi\Client;

/**
 * Retrieve pipelines of a project, optionally filtered by branch.
 *
 * @author     jmleroux <jmleroux.pro@gmail.com>
 * @link       https://circleci.com/docs/api/v2/#operation/listPipelinesForProject
 *
 * @deprecated use Jmleroux\CircleCi\Api\Project\ProjectPipelines
 */
class AllPipelines extends ProjectPipelines
{
    public function __construct(Client $client)
    {
        @trigger_error(sprintf('%s is deprecated and will be removed in next versions.', AllPipelines::class));

        parent::__construct($client);
    }
}
