<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Quiz\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
