<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests;

use donatj\MockWebServer\MockWebServer;
use donatj\MockWebServer\Response;
use donatj\MockWebServer\ResponseStack;

/**
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
class MockServer
{
    private static ?MockWebServer $server;

    public static function startServer(): void
    {
        self::$server = new MockWebServer();
        self::$server->start();

        self::$server->setResponseOfPath(
            '/api/v1.1/project/gh/jmleroux/my_project/22',
            new Response(
                file_get_contents(__DIR__ . '/resources/response/job-with-steps.json'),
                ['Cache-Control' => 'no-cache'],
                200
            )
        );
        self::$server->setResponseOfPath(
            '/api/v2/project/gh/jmleroux/my_project/666/tests',
            new Response(
                file_get_contents(__DIR__ . '/resources/response/job-test-metadata.json'),
                ['Cache-Control' => 'no-cache'],
                200
            )
        );
        self::$server->setResponseOfPath(
            '/api/v2/project/gh/jmleroux/my_project/pipeline',
            new ResponseStack(
                new Response(
                    file_get_contents(__DIR__ . '/resources/response/project-pipelines-page1.json'),
                    ['Cache-Control' => 'no-cache'],
                    200
                ),
                new Response(
                    file_get_contents(__DIR__ . '/resources/response/project-pipelines-page2.json'),
                    ['Cache-Control' => 'no-cache'],
                    200
                )
            )
        );
    }

    public static function getServerRoot(): string
    {
        return self::$server->getServerRoot();
    }
}
