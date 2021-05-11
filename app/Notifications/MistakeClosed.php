<?php

declare(strict_types=1);

namespace Quiz\Notifications;

use Illuminate\Notifications\Notification;
use Quiz\Http\Resources\Mistake\MistakeResource;
use Quiz\Models\Mistake;
use Quiz\Notifications\Channels\BroadcastChannel;
use Quiz\Notifications\Channels\DatabaseChannel;

class MistakeClosed extends Notification
{
    protected const TYPE = "closed_mistake_report";

    protected Mistake $mistake;

    public function __construct(Mistake $mistake)
    {
        $this->mistake = $mistake;
    }

    public function via(): array
    {
        return [DatabaseChannel::class, BroadcastChannel::class];
    }

    public function toArray(): array
    {
        return [
            "data" => new MistakeResource($this->mistake),
        ];
    }

    public function databaseType(): string
    {
        return static::TYPE;
    }

    public function broadcastType(): string
    {
        return static::TYPE;
    }
}
