<?php

declare(strict_types=1);

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CreatesCategories;
use Tests\Traits\CreatesUsers;

class IndexCategoryTest extends TestCase
{
    use RefreshDatabase;
    use CreatesCategories;
    use CreatesUsers;

    public function testUserCanListCategories(): void
    {
        Sanctum::actingAs($this->createUser());

        $count = 10;
        $this->createCategories($count);

        $response = $this->get("categories");

        $response->assertSuccessful();
        $response->assertJsonCount($count, "data");
    }

    public function testResponseHasPaginationData(): void
    {
        Sanctum::actingAs($this->createUser());

        $response = $this->get("categories");

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

    public function testUserCanListCategoriesWithPageParameter(): void
    {
        Sanctum::actingAs($this->createUser());

        $page = 2;
        $this->createCategories(10);

        $response = $this->get("categories?page=${page}");

        $response->assertSuccessful();
        $response->assertJsonPath("pagination.current_page", $page);
    }
}
