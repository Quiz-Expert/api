<?php

declare(strict_types=1);

namespace Quiz\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $user_id
 * @property string $category_id
 */
class StoreGameInvite extends FormRequest
{
    public function rules(): array
    {
        return [
            "user_id" => ["required", "exists:users,id"],
            "category_id" => ["required", "exists:categories,id"],
        ];
    }
}
