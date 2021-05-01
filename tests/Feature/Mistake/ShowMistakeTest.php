<?php

declare(strict_types=1);

namespace Tests\Feature\Mistake;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CreatesMistakes;
use Tests\Traits\CreatesUsers;

class ShowMistakeTest extends TestCase
{
    use RefreshDatabase;
    use CreatesMistakes;
    use CreatesUsers;

    public function testUserCanShowMistake(): void
    {
        $user = $this->createUser();
        $mistake = $this->createMistake();

        Sanctum::actingAs($user);

        $response = $this->get("mistakes/{$mistake->id}");

        $response->assertSuccessful();
    }

    public function testUserCannotShowNonExistingMistake(): void
    {
        $user = $this->createUser();
        $nonExistingId = 1234;

        Sanctum::actingAs($user);

        $response = $this->get("mistakes/${nonExistingId}");

        $response->assertNotFound();
    }
}
