<?php

declare(strict_types=1);

namespace Tests\Feature\Question;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CreatesQuestions;
use Tests\Traits\CreatesUsers;

class DeleteQuestionTest extends TestCase
{
    use RefreshDatabase;
    use CreatesQuestions;
    use CreatesUsers;

    public function testUserCanDeleteQuestion(): void
    {
        Sanctum::actingAs($this->createUser());

        $question = $this->createQuestion();

        $response = $this->delete("questions/{$question->id}");

        $response->assertSuccessful();
    }

    public function testUserCannotDeleteQuestionIfItDoesntExist(): void
    {
        Sanctum::actingAs($this->createUser());

        $nonExistingId = 1234;

        $response = $this->delete("questions/${nonExistingId}");

        $response->assertNotFound();
    }
}
