<?php

declare(strict_types=1);

namespace Modules\Auth\Api\Domain;

use Illuminate\Foundation\Auth\User;
use Modules\Auth\Application\Dto\RegisterUserData;

interface UserRepository
{
    public function register(RegisterUserData $data): User;
}
