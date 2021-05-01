<?php

declare(strict_types=1);

namespace Tests\Feature\Mistake;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\Traits\CreatesQuestions;
use Tests\Traits\CreatesUsers;

class CreateMistakeTest extends TestCase
{
    use RefreshDatabase;
    use CreatesQuestions;
    use CreatesUsers;

    public function testUserCanReportMistakeWithProperData(): void
    {
        $user = $this->createUser();
        $question = $this->createQuestion();

        Sanctum::actingAs($user);

        $response = $this->post("mistakes", [
            "text" => "Lorem ipsum",
            "question_id" => $question->id,
        ]);

        $response->assertSuccessful();
    }

    public function testUserCannotReportMistakeWithValidationErrors(): void
    {
        $user = $this->createUser();
        $question = $this->createQuestion();

        Sanctum::actingAs($user);

        $response = $this->post("mistakes", [
            "question_id" => $question->id,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["text"]);
    }
}
