<?php

declare(strict_types=1);

namespace Tests\Feature\Question;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Quiz\Models\Question;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\Traits\CreatesQuestions;
use Tests\Traits\CreatesUsers;

class UpdateQuestionTest extends TestCase
{
    use RefreshDatabase;
    use CreatesQuestions;
    use CreatesUsers;

    public function testUserCanUpdateQuestionWithProperData(): void
    {
        Sanctum::actingAs($this->createUser());

        $question = $this->createQuestion();

        $response = $this->put("questions/{$question->id}", [
            "text" => "Lorem ipsum",
            "answer_a" => "answer a",
            "answer_b" => "answer b",
            "answer_c" => "answer c",
            "answer_d" => "answer d",
            "good_answer" => Question::ANSWER_D,
            "category_id" => $question->category->id,
        ]);

        $response->assertSuccessful();
    }

    public function testUserCannotUpdateQuestionIfItDoesntExist(): void
    {
        Sanctum::actingAs($this->createUser());

        $nonExistingId = 1234;

        $response = $this->put("questions/${nonExistingId}", [
            "text" => "Lorem ipsum",
            "answer_a" => "answer a",
            "answer_b" => "answer b",
            "answer_c" => "answer c",
            "answer_d" => "answer d",
            "good_answer" => Question::ANSWER_D,
            "category_id" => "24",
        ]);

        $response->assertNotFound();
    }

    public function testUserCannotUpdateQuestionWithValidationErrors(): void
    {
        Sanctum::actingAs($this->createUser());

        $question = $this->createQuestion();

        $response = $this->put("questions/{$question->id}", [
            "good_answer" => Question::ANSWER_D,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["text", "answer_a", "answer_b", "answer_c", "answer_d", "category_id"]);
    }
}
