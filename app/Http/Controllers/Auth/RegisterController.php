<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Quiz\Http\Controllers\Controller;
use Quiz\Http\Requests\RegisterRequest;
use Quiz\Models\User;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()
            ->create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ]);

        return response()->json([
            "data" => $user->createToken(Str::random())->plainTextToken,
        ]);
    }
}
