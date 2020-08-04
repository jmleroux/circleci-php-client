<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

/**
 * @author Benoit Jacquemont <benoit@akeneo.com>
 * @link https://circleci.com/docs/api/v2/#get-test-metadata
 */
class TestMetadata implements ApiResultInterface
{
    /**
     * Raw object from Circle CI API
     *
     * @var \stdClass
     */
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

    public function message(): string
    {
        return $this->rawObject->message;
    }

    public function source(): string
    {
        return $this->rawObject->source;
    }

    public function runTime(): float
    {
        return $this->rawObject->run_time;
    }

    public function file(): string
    {
        return $this->rawObject->file;
    }

    public function result(): string
    {
        return $this->rawObject->result;
    }

    public function name(): string
    {
        return $this->rawObject->name;
    }

    public function classname(): string
    {
        return $this->rawObject->classname;
    }
}
