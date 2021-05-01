<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Quiz\Http\Resources\User\CurrentUserResource;
use Tests\TestCase;
use Tests\Traits\CreatesUsers;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;

    public function testUserCanGetHisInformation(): void
    {
        $user = $this->createUser();
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
