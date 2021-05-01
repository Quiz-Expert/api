<?php

declare(strict_types=1);

namespace Tests\Feature\Suggestion;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Quiz\Models\Suggestion;
use Tests\TestCase;
use Tests\Traits\CreatesCategories;
use Tests\Traits\CreatesSuggestions;
use Tests\Traits\CreatesUsers;

class IndexSuggestionTest extends TestCase
{
    use RefreshDatabase;
    use CreatesSuggestions;
    use CreatesCategories;
    use CreatesUsers;

    public function testUserCanListSuggestions(): void
    {
        $count = 10;
        $user = $this->createUser();
        $this->createSuggestions($count);

        Sanctum::actingAs($user);

        $response = $this->get("suggestions");

        $response->assertSuccessful();
        $response->assertJsonCount($count, "data");
    }

    public function testResponseHasPaginationData(): void
    {
        $user = $this->createUser();

        Sanctum::actingAs($user);

        $response = $this->get("suggestions");

        $response->assertSuccessful();
        $response->assertJsonStructure([
            "data",
            "pagination" => [
                "total",
                "count",
                "per_page",
                "current_page",
                "total_pages",
            ],
        ]);
    }

    public function testUserCanListSuggestionsWithPageParameter(): void
    {
        $page = 2;
        $user = $this->createUser();
        $this->createSuggestions(10);

        Sanctum::actingAs($user);

        $response = $this->get("suggestions?page=${page}");

        $response->assertSuccessful();
        $response->assertJsonPath("pagination.current_page", $page);
    }

    public function testUserCanListSuggestionsByCategory(): void
    {
        $user = $this->createUser();
        $categoryA = $this->createCategory();
        $categoryB = $this->createCategory();

        $categoryACount = 4;
        $categoryBCount = 3;

        $this->createSuggestions($categoryACount, $user, $categoryA);
        $this->createSuggestions($categoryBCount, $user, $categoryB);

        Sanctum::actingAs($user);

        $response = $this->get("suggestions?category={$categoryA->id}");

        $response->assertSuccessful();
        $response->assertJsonCount($categoryACount, "data");
    }

    public function testUserCanListSuggestionsByStatus(): void
    {
        $user = $this->createUser();

        $acceptedCount = 11;
        $pendingCount = 137;

        $this->createSuggestions($acceptedCount, $user, null, [
            "status" => Suggestion::STATUS_ACCEPTED,
        ]);
        $this->createSuggestions($pendingCount, $user, null, [
            "status" => Suggestion::STATUS_PENDING,
        ]);

        Sanctum::actingAs($user);

        $response = $this->get("suggestions?status=" . Suggestion::STATUS_ACCEPTED);

        $response->assertSuccessful();
        $response->assertJsonCount($acceptedCount, "data");
    }
}
