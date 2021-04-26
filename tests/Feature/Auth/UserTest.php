<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Quiz\Http\Resources\CurrentUserResource;
use Tests\CreatesUsers;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;

    public function testUserCanGetHisInformation(): void
    {
        $user = $this->createUser("test@example.com");
        $expectedResponse = (new CurrentUserResource($user))->response();

        Sanctum::actingAs($user);

        $response = $this->get("auth/user");

        $response->assertSuccessful();
        $response->assertExactJson($expectedResponse->getData(true));
    }

    public function testUserCannotGetHisInformationWhenUnauthenticated(): void
    {
        $response = $this->get("auth/user");

        $response->assertUnauthorized();
    }
}
