<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class JobOutcome
{
    const CANCELED = 'canceled';
    const INFRASTRUCTURE_FAIL = 'infrastructure_fail';
    const TIMEOUT = 'timedout';
    const FAILED = 'failed';
    const NO_TESTS = 'no_tests';
    const SUCCESS = 'success';
}
