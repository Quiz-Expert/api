<?php

declare(strict_types=1);

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\Traits\CreatesCategories;
use Tests\Traits\CreatesUsers;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;
    use CreatesCategories;
    use CreatesUsers;

    public function testUserCanCreateCategoryWithProperData(): void
    {
        Sanctum::actingAs($this->createUser());

        $response = $this->post("categories", [
            "name" => "The name of category",
            "description" => "lorem ipsum",
            "icon" => "8d213da21.png",
        ]);

        $response->assertSuccessful();
    }

    public function testUserCannotCreateCategoryWithValidationErrors(): void
    {
        Sanctum::actingAs($this->createUser());

        $response = $this->post("categories", [
            "description" => "lorem ipsum",
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["name", "icon"]);
    }

    public function testUserCannotCreateCategoryWithExistingName(): void
    {
        Sanctum::actingAs($this->createUser());

        $existingName = "Existing category";

        $this->createCategory([
            "name" => $existingName,
        ]);

        $response = $this->post("categories", [
            "name" => $existingName,
            "description" => "lorem ipsum",
            "icon" => "8d213da21.png",
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["name"]);
    }
}
