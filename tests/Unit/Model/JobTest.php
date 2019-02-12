<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Unit\Model;

use Jmleroux\CircleCi\Model\Job;
use PHPUnit\Framework\TestCase;

class JobTest extends TestCase
{
    public function testCreateFromJson()
    {
        $json = file_get_contents(__DIR__ . '/../resources/job.json');
        $job = Job::createFromJson($json);
        $this->assertInstanceOf(Job::class, $job);
    }

    public function testNormalize()
    {
        $json = file_get_contents(__DIR__ . '/../resources/job.json');
        $job = Job::createFromJson($json);

        $expected = [
            'vcsUrl' => 'https://github.com/circleci/mongofinil',
            'buildUrl' => 'https://circleci.com/gh/circleci/mongofinil/22',
            'buildNum' => 22,
            'branch' => 'master',
            'startTime' => '2013-02-12 21:33:38',
            'stopTime' => '2013-02-12 21:34:01',
            'buildTimeMillis' => 23505,
            'outcome' => 'success',
            'status' => 'success',
            'steps' => [
                'configure the build' => [
                    'name' => 'configure the build',
//                    'actions' => [
//                        [
//                            'bash_command' => null,
//                            'run_time_millis' => 1646,
//                            'start_time' => '2013-02-12T21:33:38Z',
//                            'end_time' => '2013-02-12T21:33:39Z',
//                            'name' => 'configure the build',
//                            'exit_code' => null,
//                            'type' => 'infrastructure',
//                            'index' => 0,
//                            'status' => 'success',
//                        ],
//                    ],
                ],
                'lein2 deps' => [
                    'name' => 'lein2 deps',
//                    'actions' => [
//                        [
//                            'bash_command' => 'lein2 deps',
//                            'run_time_millis' => 7555,
//                            'start_time' => '2013-02-12T21:33:47Z',
//                            'messages' =>
//                                [
//                                ],
//                            'step' => 1,
//                            'exit_code' => 0,
//                            'end_time' => '2013-02-12T21:33:54Z',
//                            'index' => 0,
//                            'status' => 'success',
//                            'type' => 'dependencies',
//                            'source' => 'inference',
//                            'failed' => null,
//                        ],
                ],
            ],
        ];

        $this->assertSame($expected, $job->normalize());
    }
}
