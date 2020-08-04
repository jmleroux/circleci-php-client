<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration;

use GuzzleHttp\Exception\ClientException;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
trait ExecuteWithRetryTrait
{
    protected function executeWithRetry($query, array $arguments)
    {
        $retryNumber = 0;
        while ($retryNumber <= 3) {
            try {
                return call_user_func_array([$query, 'execute'], $arguments);
            } catch (ClientException $e) {
                if ($e->getCode() === 429 && $retryNumber < 3) {
                    sleep(10);
                    ++$retryNumber;
                } else {
                    throw $e;
                }
            }
        }
    }
}
