<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model\Pipeline\Vcs;

use DateTimeImmutable;
use Jmleroux\CircleCi\Model\ApiResultInterface;

/**
 * @author Brice Le Boulch <airmanbzh@gmail.com>
 * @link https://circleci.com/docs/api/v2/#get-a-pipeline
 */
final class Commit implements ApiResultInterface
{
    /** @var \stdClass */
    private $rawObject;

    private function __construct(\stdClass $rawObject)
    {
        $this->rawObject = $rawObject;
    }

    public static function createFromApi(\stdClass $rawObject): self
    {
        return new self($rawObject);
    }

    public function rawValues(): \stdClass
    {
        return $this->rawObject;
    }

    public function body(): string
    {
        return $this->rawObject->body;
    }

    public function subject(): string
    {
        return $this->rawObject->subject;
    }
}
