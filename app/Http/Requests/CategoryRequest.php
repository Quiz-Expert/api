<?php

declare(strict_types=1);

namespace Quiz\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Quiz\Models\Category;

/**
 * @property string $name
 * @property string $description
 * @property Category|null $category
 */
class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => [
                "required",
                Rule::unique("categories", "name")->ignore($this->category?->id),
            ],
            "description" => ["required", "min:5"],
            "icon" => ["required"],
        ];
    }

    public function getData(): array
    {
        return $this->only("name", "description", "icon");
    }
}
