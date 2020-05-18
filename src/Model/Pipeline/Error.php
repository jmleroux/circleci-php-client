<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model\Pipeline;

/**
 * @author Benoit Jacquemont <benoit@akeneo.com>
 */
final class Error
{
    /**
     * Raw object from Circle CI API
     *
     * @var \stdClass
     */
    private $rawObject;

    /** @var string */
    private $type;

    /** @var string */
    private $message;

    private function __construct(\stdClass $rawObject)
    {
        $this->type = $rawObject->type;
        $this->message = $rawObject->message;
    }

    public static function createFromApi(\stdClass $rawObject): self
    {
        return new self($rawObject);
    }

    public function tyoe(): string
    {
        return $this->type;
    }

    public function message(): string
    {
        return $this->message;
    }
}
