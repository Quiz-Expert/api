<?php

declare(strict_types=1);

namespace Tests\Feature\Question;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesQuestions;

class DeleteQuestionTest extends TestCase
{
    use RefreshDatabase;
    use CreatesQuestions;

    public function testUserCanDeleteQuestion(): void
    {
        $question = $this->createQuestion();

        $response = $this->delete("questions/{$question->id}");

        $response->assertSuccessful();
    }

    public function testUserCannotDeleteQuestionIfItDoesntExist(): void
    {
        $nonExistingId = 1234;

        $response = $this->delete("questions/${nonExistingId}");

        $response->assertNotFound();
    }
}
