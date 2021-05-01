<?php

declare(strict_types=1);

namespace Tests\Feature\Suggestion;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Quiz\Models\Question;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\Traits\CreatesCategories;
use Tests\Traits\CreatesUsers;

class CreateSuggestionTest extends TestCase
{
    use RefreshDatabase;
    use CreatesCategories;
    use CreatesUsers;

    public function testUserCanCreateSuggestionWithProperData(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        Sanctum::actingAs($user);

        $response = $this->post("suggestions", [
            "text" => "Lorem ipsum",
            "answer_a" => "answer a",
            "answer_b" => "answer b",
            "answer_c" => "answer c",
            "answer_d" => "answer d",
            "good_answer" => Question::ANSWER_D,
            "category_id" => $category->id,
        ]);

        $response->assertSuccessful();
    }

    public function testUserCannotCreateSuggestionWithValidationErrors(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        Sanctum::actingAs($user);

        $response = $this->post("suggestions", [
            "text" => "Lorem ipsum",
            "answer_a" => "answer a",
            "answer_b" => "answer b",
            "good_answer" => "e",
            "category_id" => $category->id,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["answer_c", "answer_d", "good_answer"]);
    }

    public function testUserCannotCreateSuggestionForNonExistingCategory(): void
    {
        $user = $this->createUser();
        $nonExistingCategoryId = 156;

        Sanctum::actingAs($user);

        $response = $this->post("suggestions", [
            "text" => "Lorem ipsum",
            "answer_a" => "answer a",
            "answer_b" => "answer b",
            "answer_c" => "answer c",
            "answer_d" => "answer d",
            "good_answer" => Question::ANSWER_D,
            "category_id" => $nonExistingCategoryId,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["category_id"]);
    }
}
