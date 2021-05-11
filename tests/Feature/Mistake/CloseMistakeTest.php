<?php

declare(strict_types=1);

namespace Tests\Feature\Mistake;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CreatesMistakes;
use Tests\Traits\CreatesUsers;

class CloseMistakeTest extends TestCase
{
    use RefreshDatabase;
    use CreatesMistakes;
    use CreatesUsers;

    public function testUserCanCloseMistake(): void
    {
        $this->withoutNotifications();

        $user = $this->createUser();
        $mistake = $this->createMistake();

        Sanctum::actingAs($user);

        $response = $this->post("mistakes/{$mistake->id}/close");

        $response->assertSuccessful();
    }

    public function testUserCannotCloseMistakeIfItDoesntExist(): void
    {
        $this->withoutNotifications();

        $user = $this->createUser();
        $nonExistingId = 1234;

        Sanctum::actingAs($user);

        $response = $this->post("mistakes/${nonExistingId}/close");

        $response->assertNotFound();
    }
}
