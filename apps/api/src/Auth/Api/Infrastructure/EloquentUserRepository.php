<?php

declare(strict_types=1);

namespace Modules\Auth\Api\Infrastructure;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Api\Domain\UserRepository;
use Modules\Auth\Application\Dto\RegisterUserData;

class EloquentUserRepository implements UserRepository
{
    public function register(RegisterUserData $data): User
    {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
    }
}
