<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests;

use donatj\MockWebServer\MockWebServer;
use donatj\MockWebServer\Response;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class MockServer
{
    /** @var MockWebServer */
    private static $server;

    public static function startServer(): void
    {
        self::$server = new MockWebServer();
        self::$server->start();

        self::$server->setResponseOfPath(
            '/api/v1.1/project/gh/jmleroux/my_project/22',
            new Response(
                file_get_contents(__DIR__.'/resources/response/job-with-steps.json'),
                ['Cache-Control' => 'no-cache'],
                200
            )
        );
        self::$server->setResponseOfPath(
            '/api/v2/project/gh/jmleroux/my_project/666/tests',
            new Response(
                file_get_contents(__DIR__.'/resources/response/job-test-metadata.json'),
                ['Cache-Control' => 'no-cache'],
                200
            )
        );
    }

    public static function getServerRoot(): string
    {
        return self::$server->getServerRoot();
    }
}
