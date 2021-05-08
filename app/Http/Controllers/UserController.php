<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Quiz\Http\Resources\User\UserResource;
use Quiz\Models\User;

class UserController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        $search = $request->get("search");

        $usersQuery = User::query();

        if ($search !== null) {
            $usersQuery->search($search);
        }

        return UserResource::collection($usersQuery->get());
    }
}
