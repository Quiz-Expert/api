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
 * @property bool $is_active
 * @property int $question_id
 * @property Question $question
 * @property int $user_id
 * @property User $user
 */
class Mistake extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        "is_active" => "boolean",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function close(): void
    {
        $this->is_active = false;

        $this->save();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where("is_active", true);
    }
}
