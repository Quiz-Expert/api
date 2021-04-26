<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Quiz\Http\Controllers\Controller;
use Quiz\Http\Requests\LoginFormRequest;
use Quiz\Models\User;

class LoginController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(LoginFormRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()
            ->where("email", $request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                "email" => ["The provided credentials are incorrect."],
            ]);
        }

        return response()->json([
            "data" => $user->createToken(Str::random())->plainTextToken,
        ]);
    }
}
