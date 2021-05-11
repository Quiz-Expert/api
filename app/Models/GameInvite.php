<?php

declare(strict_types=1);

namespace Quiz\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $sender_id
 * @property User $sender
 * @property string $recipient_id
 * @property User $recipient
 * @property int $category_id
 * @property Category $category
 */
class GameInvite extends Model
{
    protected $guarded = [];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, "sender_id", "id");
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, "recipient_id", "id");
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
