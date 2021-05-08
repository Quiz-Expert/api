<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Quiz\Http\Requests\CategoryRequest;
use Quiz\Http\Resources\Category\CategoryCollection;
use Quiz\Http\Resources\Category\CategoryResource;
use Quiz\Http\Resources\Category\SimpleCategoryResource;
use Quiz\Http\Resources\PaginatedCollection;
use Quiz\Models\Category;

class CategoryController extends Controller
{
    public function index(): PaginatedCollection
    {
        $categories = Category::query()->paginate();

        return new CategoryCollection($categories);
    }

    public function all(Request $request): ResourceCollection
    {
        $search = $request->get("search");

        $categoriesQuery = Category::query()
            ->select(["id", "name"]);

        if ($search !== null) {
            $categoriesQuery->search($search);
        }

        return SimpleCategoryResource::collection($categoriesQuery->get());
    }

    public function store(CategoryRequest $request): JsonResource
    {
        $category = Category::query()->create($request->getData());

        return new CategoryResource($category);
    }

    public function show(Category $category): JsonResource
    {
        return new CategoryResource($category);
    }

    public function update(Category $category, CategoryRequest $request): JsonResource
    {
        $category->update($request->getData());

        return new CategoryResource($category);
    }

    /**
     * @throws Exception
     */
    public function delete(Category $category): Response
    {
        $category->delete();

        return response()->noContent();
    }
}
