<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model\Pipeline;

/**
 * @author Benoit Jacquemont <benoit@akeneo.com>
 */
final class Actor
{
    /** @var string */
    private $login;

    /** @var string */
    private $avatarUrl;

    private function __construct(string $login, string $avatarUrl)
    {
        $this->login = $login;
        $this->avatarUrl = $avatarUrl;
    }

    public static function createFromApi(\stdClass $rawObject): self
    {
        return new self($rawObject->login, $rawObject->url);
    }

    public function login(): string
    {
        return $this->login;
    }

    public function avatarUrl(): string
    {
        return $this->avatarUrl;
    }
}
