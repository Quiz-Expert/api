<?php

declare(strict_types=1);

namespace Quiz\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $text
 * @property string $answer_a;
 * @property string $answer_b;
 * @property string $answer_c;
 * @property string $answer_d;
 * @property string $good_answer;
 * @property string $status
 * @property int $category_id
 * @property Category $category
 * @property int $user_id
 * @property User $user
 */
class Suggestion extends Model
{
    use HasFactory;

    public const STATUS_ACCEPTED = "accepted";
    public const STATUS_PENDING = "pending";
    public const STATUS_REJECTED = "rejected";

    protected $guarded = [];

    public static function statutes(): array
    {
        return [
            static::STATUS_ACCEPTED,
            static::STATUS_PENDING,
            static::STATUS_REJECTED,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function accept(): void
    {
        $this->status = static::STATUS_ACCEPTED;

        $this->save();
    }

    public function reject(): void
    {
        $this->status = static::STATUS_REJECTED;

        $this->save();
    }

    public function isAccepted(): bool
    {
        return $this->status === static::STATUS_ACCEPTED;
    }

    public function isPending(): bool
    {
        return $this->status === static::STATUS_PENDING;
    }

    public function isRejected(): bool
    {
        return $this->status === static::STATUS_REJECTED;
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where("status", $status);
    }
}
