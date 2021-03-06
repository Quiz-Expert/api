<?php

declare(strict_types=1);

namespace Tests\Feature\Suggestion;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CreatesSuggestions;
use Tests\Traits\CreatesUsers;

class RejectSuggestionTest extends TestCase
{
    use RefreshDatabase;
    use CreatesSuggestions;
    use CreatesUsers;

    public function testUserCanRejectSuggestion(): void
    {
        $this->withoutNotifications();

        $user = $this->createUser();
        $suggestion = $this->createSuggestion();

        Sanctum::actingAs($user);

        $response = $this->post("suggestions/{$suggestion->id}/reject");

        $response->assertSuccessful();
    }

    public function testUserCannotRejectSuggestionIfItDoesntExist(): void
    {
        $this->withoutNotifications();

        $user = $this->createUser();
        $nonExistingId = 1234;

        Sanctum::actingAs($user);

        $response = $this->post("suggestions/${nonExistingId}/reject");

        $response->assertNotFound();
    }
}
