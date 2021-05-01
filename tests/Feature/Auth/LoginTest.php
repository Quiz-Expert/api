<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\Traits\CreatesUsers;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;

    public function testUserCanLoginWithProperCredentials(): void
    {
        $email = "test@example.com";

        $this->createUser($email);

        $response = $this->post("auth/login", [
            "email" => $email,
            "password" => "secret123",
        ]);

        $response->assertSuccessful();
    }

    public function testUserCannotLoginWithWrongCredentials(): void
    {
        $email = "test@example.com";

        $this->createUser($email, "differentPassword123");

        $response = $this->post("auth/login", [
            "email" => $email,
            "password" => "secret123",
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors("email");
    }

    public function testUserCannotLoginIfHeDoesntExist(): void
    {
        $response = $this->post("auth/login", [
            "email" => "userwhodoesntexists@example.com",
            "password" => "secret123",
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors("email");
    }
}
