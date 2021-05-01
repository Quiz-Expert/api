<?php

declare(strict_types=1);

namespace Tests\Feature\Suggestion;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Quiz\Models\Suggestion;
use Tests\TestCase;
use Tests\Traits\CreatesSuggestions;
use Tests\Traits\CreatesUsers;

class AcceptSuggestionTest extends TestCase
{
    use RefreshDatabase;
    use CreatesSuggestions;
    use CreatesUsers;

    public function testUserCanAcceptSuggestion(): void
    {
        $user = $this->createUser();
        $suggestion = $this->createSuggestion([
            "status" => Suggestion::STATUS_PENDING,
        ]);

        Sanctum::actingAs($user);

        $response = $this->post("suggestions/{$suggestion->id}/accept");

        $response->assertSuccessful();
        $this->assertDatabaseCount("questions", 1);
    }

    public function testUserCannotAcceptSuggestionIfItDoesntExist(): void
    {
        $user = $this->createUser();
        $nonExistingId = 1234;

        Sanctum::actingAs($user);

        $response = $this->post("suggestions/${nonExistingId}/accept");

        $response->assertNotFound();
    }
}
