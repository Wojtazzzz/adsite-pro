<?php

declare(strict_types=1);

namespace Modules\Auth\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Api\Requests\LoginRequest;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }

    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
        ]);
    }
}
