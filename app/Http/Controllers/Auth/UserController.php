<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Quiz\Http\Controllers\Controller;
use Quiz\Http\Resources\CurrentUserResource;

class UserController extends Controller
{
    public function __invoke(Request $request): JsonResource
    {
        return new CurrentUserResource($request->user());
    }
}
