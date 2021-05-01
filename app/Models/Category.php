<?php

declare(strict_types=1);

namespace Quiz\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $email
 * @property string $description
 * @property string $icon
 * @property string $icon_url
 * @property Collection|Question[] $questions
 */
class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const UPLOAD_DIRECTORY = "icons";

    protected $guarded = [];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function getIconUrlAttribute(): string
    {
        return asset(static::UPLOAD_DIRECTORY . "/" . $this->icon);
    }
}
