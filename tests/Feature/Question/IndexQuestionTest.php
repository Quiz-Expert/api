<?php

declare(strict_types=1);

namespace Tests\Feature\Question;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CreatesCategories;
use Tests\Traits\CreatesQuestions;
use Tests\Traits\CreatesUsers;

class IndexQuestionTest extends TestCase
{
    use RefreshDatabase;
    use CreatesQuestions;
    use CreatesCategories;
    use CreatesUsers;

    public function testUserCanListQuestions(): void
    {
        Sanctum::actingAs($this->createUser());

        $count = 10;
        $this->createQuestions($count);

        $response = $this->get("questions");

        $response->assertSuccessful();
        $response->assertJsonCount($count, "data");
    }

    public function testResponseHasPaginationData(): void
    {
        Sanctum::actingAs($this->createUser());

        $response = $this->get("questions");

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

    public function testUserCanListQuestionsWithPageParameter(): void
    {
        Sanctum::actingAs($this->createUser());

        $page = 2;
        $this->createQuestions(10);

        $response = $this->get("questions?page=${page}");

        $response->assertSuccessful();
        $response->assertJsonPath("pagination.current_page", $page);
    }

    public function testUserCanListQuestionsByCategory(): void
    {
        Sanctum::actingAs($this->createUser());

        $categoryA = $this->createCategory();
        $categoryB = $this->createCategory();

        $categoryACount = 5;
        $categoryBCount = 7;

        $this->createQuestions($categoryACount, $categoryA);
        $this->createQuestions($categoryBCount, $categoryB);

        $response = $this->get("questions?category={$categoryA->id}");

        $response->assertSuccessful();
        $response->assertJsonCount($categoryACount, "data");
    }
}
