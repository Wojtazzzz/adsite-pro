<?php

declare(strict_types=1);

namespace Modules\Auth\Application\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Auth\Api\Domain\UserRepository;
use Modules\Auth\Application\Dto\RegisterUserData;

readonly class RegisterService
{
    public function __construct(
        private UserRepository $user
    )
    {
    }

    public function register(RegisterUserData $data): void
    {
        $user = $this->user->register($data);

        Auth::login($user);
    }
}
