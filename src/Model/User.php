<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class User implements ModelInterface
{
    /** @var bool */
    public $isUser = false;
    /** @var string */
    public $login;
    /** @var string */
    public $name;
    /** @var string */
    public $avatarUrl;

    private function __construct(bool $isUser, string $login, ?string $name, ?string $avatarUrl)
    {
        $this->isUser = $isUser;
        $this->login = $login;
        $this->name = $name;
        $this->avatarUrl = $avatarUrl;
    }

    public static function createFromNormalized(array $decodedValues): User
    {
        return new self(
            $decodedValues['is_user'],
            $decodedValues['login'],
            $decodedValues['name'] ?? null,
            $decodedValues['avatar_url'] ?? null
        );
    }

    public static function createEmpty(): User
    {
        return new self(false, 'empty_user', 'no_name', null);
    }

    public function toJson(): string
    {
        return json_encode($this->normalize());
    }

    public function normalize(): array
    {
        return [
            'is_user' => $this->isUser,
            'login' => $this->login,
            'name' => $this->name,
            'avatar_url' => $this->avatarUrl,
        ];
    }
}
