<?php

declare(strict_types=1);

namespace Quiz\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $text
 * @property string $answer_a;
 * @property string $answer_b;
 * @property string $answer_c;
 * @property string $answer_d;
 * @property string $good_answer;
 * @property int $category_id
 * @property Category $category
 */
class Question extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const ANSWER_A = "a";
    public const ANSWER_B = "b";
    public const ANSWER_C = "c";
    public const ANSWER_D = "d";

    protected $fillable = [
        "text",
        "answer_a",
        "answer_b",
        "answer_c",
        "answer_d",
        "good_answer",
        "category_id",
    ];

    public static function possibleAnswers(): array
    {
        return [
            static::ANSWER_A,
            static::ANSWER_B,
            static::ANSWER_C,
            static::ANSWER_D,
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
