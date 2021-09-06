<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi;

use Webmozart\Assert\Assert;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
trait ValidateClientVersionTrait
{
    /**
     * @param Client $client
     * @param string[]  $supportedVersions
     */
    private function validateClientVersion(Client $client, array $supportedVersions): void
    {
        Assert::inArray(
            $client->getVersion(),
            $supportedVersions,
            sprintf(
                'This API only support "%s" client versions. "%s" provided.',
                implode(', ', $supportedVersions),
                $client->getVersion()
            )
        );
    }
}
