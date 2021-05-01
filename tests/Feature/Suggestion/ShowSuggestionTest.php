<?php

declare(strict_types=1);

namespace Tests\Feature\Suggestion;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CreatesSuggestions;
use Tests\Traits\CreatesUsers;

class ShowSuggestionTest extends TestCase
{
    use RefreshDatabase;
    use CreatesSuggestions;
    use CreatesUsers;

    public function testUserCanShowSuggestion(): void
    {
        $user = $this->createUser();
        $suggestion = $this->createSuggestion();

        Sanctum::actingAs($user);

        $response = $this->get("suggestions/{$suggestion->id}");

        $response->assertSuccessful();
    }

    public function testUserCannotShowNonExistingSuggestion(): void
    {
        $user = $this->createUser();
        $nonExistingId = 1234;

        Sanctum::actingAs($user);

        $response = $this->get("suggestions/${nonExistingId}");

        $response->assertNotFound();
    }
}
