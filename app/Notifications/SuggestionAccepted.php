<?php

declare(strict_types=1);

namespace Quiz\Notifications;

use Illuminate\Notifications\Notification;
use Quiz\Http\Resources\Suggestion\SuggestionResource;
use Quiz\Models\Suggestion;
use Quiz\Notifications\Channels\BroadcastChannel;
use Quiz\Notifications\Channels\DatabaseChannel;

class SuggestionAccepted extends Notification
{
    protected const TYPE = "accepted_suggestion";

    protected Suggestion $suggestion;

    public function __construct(Suggestion $suggestion)
    {
        $this->suggestion = $suggestion;
    }

    public function via(): array
    {
        return [DatabaseChannel::class, BroadcastChannel::class];
    }

    public function toArray(): array
    {
        return [
            "data" => new SuggestionResource($this->suggestion),
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
