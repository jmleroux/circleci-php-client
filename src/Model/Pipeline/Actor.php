<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model\Pipeline;

use Jmleroux\CircleCi\Model\ApiResultInterface;

/**
 * @author Benoit Jacquemont <benoit@akeneo.com>
 * @link https://circleci.com/docs/api/v2/#get-a-pipeline
 */
final class Actor implements ApiResultInterface
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

    public function login(): string
    {
        return $this->rawObject->login;
    }

    public function avatarUrl(): string
    {
        return $this->rawObject->url;
    }
}
