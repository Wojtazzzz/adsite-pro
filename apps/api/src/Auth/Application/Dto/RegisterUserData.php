<?php

declare(strict_types=1);

namespace Modules\Auth\Application\Dto;

readonly class RegisterUserData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
        );
    }

}
