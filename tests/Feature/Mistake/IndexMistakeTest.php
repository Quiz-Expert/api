<?php

declare(strict_types=1);

namespace Tests\Feature\Mistake;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CreatesMistakes;
use Tests\Traits\CreatesUsers;

class IndexMistakeTest extends TestCase
{
    use RefreshDatabase;
    use CreatesMistakes;
    use CreatesUsers;

    public function testUserCanListMistakes(): void
    {
        $count = 10;
        $user = $this->createUser();
        $this->createMistakes($count);

        Sanctum::actingAs($user);

        $response = $this->get("mistakes");

        $response->assertSuccessful();
        $response->assertJsonCount($count, "data");
    }

    public function testResponseHasPaginationData(): void
    {
        $user = $this->createUser();

        Sanctum::actingAs($user);

        $response = $this->get("mistakes");

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

    public function testUserCanListMistakesWithPageParameter(): void
    {
        $page = 2;
        $user = $this->createUser();
        $this->createMistakes(10);

        Sanctum::actingAs($user);

        $response = $this->get("mistakes?page=${page}");

        $response->assertSuccessful();
        $response->assertJsonPath("pagination.current_page", $page);
    }
}
