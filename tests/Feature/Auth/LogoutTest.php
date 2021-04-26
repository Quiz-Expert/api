<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\CreatesUsers;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;

    public function testUserCanLogout(): void
    {
        $user = $this->createUser("test@example.com");

        Sanctum::actingAs($user);

        $response = $this->post("auth/logout");

        $response->assertSuccessful();
    }

    public function testUserCannotLogutWhenUnauthenticated(): void
    {
        $this->createUser("test@example.com");

        $response = $this->post("auth/logout");

        $response->assertUnauthorized();
    }
}
