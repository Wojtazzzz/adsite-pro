<?php

declare(strict_types=1);

namespace Modules\Auth\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Auth\Api\Requests\RegisterRequest;
use Modules\Auth\Application\Dto\RegisterUserData;
use Modules\Auth\Application\Services\RegisterService;

class RegisteredUserController extends Controller
{
    public function __construct(
        private readonly RegisterService $registerService
    )
    {
    }

    public function store(RegisterRequest $request): Response
    {
        $this->registerService->register(
            RegisterUserData::fromArray($request->validated())
        );

        return response()->noContent();
    }
}
