<?php

declare(strict_types=1);

namespace Tests\Feature\Question;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesQuestions;
use Tests\TestCase;

class ShowQuestionTest extends TestCase
{
    use RefreshDatabase;
    use CreatesQuestions;

    public function testUserCanShowQuestion(): void
    {
        $question = $this->createQuestion();

        $response = $this->get("questions/{$question->id}");

        $response->assertSuccessful();
    }

    public function testUserCannotShowNonExistingQuestion(): void
    {
        $nonExistingId = 1234;

        $response = $this->get("questions/${nonExistingId}");

        $response->assertNotFound();
    }
}
