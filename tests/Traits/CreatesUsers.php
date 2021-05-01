<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Support\Facades\Hash;
use Quiz\Models\User;

trait CreatesUsers
{
    public function createUser(string $email = "test@example.com", string $password = "secret123"): User
    {
        return User::factory([
            "email" => $email,
            "password" => Hash::make($password),
        ])->create();
    }
}
