<?php

declare(strict_types=1);

namespace Tests\Feature\Question;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CreatesQuestions;
use Tests\Traits\CreatesUsers;

class ShowQuestionTest extends TestCase
{
    use RefreshDatabase;
    use CreatesQuestions;
    use CreatesUsers;

    public function testUserCanShowQuestion(): void
    {
        Sanctum::actingAs($this->createUser());

        $question = $this->createQuestion();

        $response = $this->get("questions/{$question->id}");

        $response->assertSuccessful();
    }

    public function testUserCannotShowNonExistingQuestion(): void
    {
        Sanctum::actingAs($this->createUser());

        $nonExistingId = 1234;

        $response = $this->get("questions/${nonExistingId}");

        $response->assertNotFound();
    }
}
