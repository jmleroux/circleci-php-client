<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\Workflow;

use GuzzleHttp\Exception\RequestException;
use Jmleroux\CircleCi\Api\Workflow\CancelWorkflow;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;

class CancelWorkflowTest extends TestCase
{
    /** @var Client */
    private $client;

    public static function setUpBeforeClass(): void
    {
        sleep(1);
    }

    public function setUp(): void
    {
        $PERSONALToken = $_ENV['CIRCLECI_PERSONNAL_TOKEN'];
        $this->client = new Client($PERSONALToken, 'v2');
    }

    public function testQueryKo()
    {
        $this->expectException(RequestException::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage('{"message":"Workflow not found"}');

        $query = new CancelWorkflow($this->client);
        $query->execute('foobar');
    }
}
