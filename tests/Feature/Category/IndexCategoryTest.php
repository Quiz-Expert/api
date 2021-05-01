<?php

declare(strict_types=1);

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesCategories;
use Tests\TestCase;

class IndexCategoryTest extends TestCase
{
    use RefreshDatabase;
    use CreatesCategories;

    public function testUserCanListCategories(): void
    {
        $count = 10;
        $this->createCategories($count);

        $response = $this->get("categories");

        $response->assertSuccessful();
        $response->assertJsonCount($count, "data");
    }

    public function testResponseHasPaginationData(): void
    {
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
        $page = 2;
        $this->createCategories(10);

        $response = $this->get("categories?page=${page}");

        $response->assertSuccessful();
        $response->assertJsonPath("pagination.current_page", $page);
    }
}
