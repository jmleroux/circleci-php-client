<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class JobStatus
{
    const RETRIED = 'retried';
    const CANCELED = 'canceled';
    const INFRASTRUCTURE_FAIL = 'infrastructure_fail';
    const TIMEDOUT = 'timedout';
    const NOT_RUN = 'not_run';
    const RUNNING = 'running';
    const FAILED = 'failed';
    const QUEUED = 'queued';
    const SCHEDULED = 'scheduled';
    const NOT_RUNNING = 'not_running';
    const NO_TESTS = 'no_tests';
    const FIXED = 'fixed';
    const SUCCESS = 'success';
}
