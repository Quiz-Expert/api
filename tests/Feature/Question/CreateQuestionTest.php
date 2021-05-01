<?php

declare(strict_types=1);

namespace Tests\Feature\Question;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Quiz\Models\Question;
use Symfony\Component\HttpFoundation\Response;
use Tests\CreatesCategories;
use Tests\CreatesQuestions;
use Tests\TestCase;

class CreateQuestionTest extends TestCase
{
    use RefreshDatabase;
    use CreatesQuestions;
    use CreatesCategories;

    public function testUserCanCreateQuestionWithProperData(): void
    {
        $category = $this->createCategory();

        $response = $this->post("questions", [
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

    public function testUserCannotCreateQuestionWithValidationErrors(): void
    {
        $category = $this->createCategory();

        $response = $this->post("questions", [
            "text" => "Lorem ipsum",
            "answer_a" => "answer a",
            "answer_b" => "answer b",
            "good_answer" => "e",
            "category_id" => $category->id,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["answer_c", "answer_d", "good_answer"]);
    }

    public function testUserCannotCreateQuestionForNonExistingCategory(): void
    {
        $nonExistingCategoryId = 156;

        $response = $this->post("questions", [
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
