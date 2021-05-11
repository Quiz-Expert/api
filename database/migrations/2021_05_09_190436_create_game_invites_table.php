<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameInvitesTable extends Migration
{
    public function up(): void
    {
        Schema::create("game_invites", function (Blueprint $table): void {
            $table->id();
            $table->foreignId("sender_id")->constrained("users")->onDelete("cascade");
            $table->foreignId("recipient_id")->constrained("users")->onDelete("cascade");
            $table->foreignId("category_id")->constrained("categories")->onDelete("cascade");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("game_invites");
    }
}
