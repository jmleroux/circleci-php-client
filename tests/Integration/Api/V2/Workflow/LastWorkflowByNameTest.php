<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Integration\Api\V2\Workflow;

use Jmleroux\CircleCi\Api\V2\Workflow\LastWorkflowByName;
use Jmleroux\CircleCi\Client;
use PHPUnit\Framework\TestCase;

class LastWorkflowByNameTest extends TestCase
{
    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $this->client = new Client('c12be1379ca68b91d314ff3b44de7b7555b3c652', 'v2');
    }

    public function testQuery()
    {
        $query = new LastWorkflowByName($this->client);
        $result = $query->execute('build_test', null);

        $this->assertInstanceOf(\stdClass::class, $result);
    }
}
