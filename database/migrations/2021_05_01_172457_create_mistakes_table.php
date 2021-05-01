<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMistakesTable extends Migration
{
    public function up(): void
    {
        Schema::create("mistakes", function (Blueprint $table): void {
            $table->id();
            $table->text("text");
            $table->foreignId("question_id")->constrained()->onDelete("cascade");
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->string("is_active")->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("mistakes");
    }
}
