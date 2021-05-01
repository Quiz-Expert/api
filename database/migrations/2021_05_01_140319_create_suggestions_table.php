<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Quiz\Models\Suggestion;

class CreateSuggestionsTable extends Migration
{
    public function up(): void
    {
        Schema::create("suggestions", function (Blueprint $table): void {
            $table->id();
            $table->text("text");
            $table->foreignId("category_id")->constrained()->onDelete("cascade");
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->string("answer_a");
            $table->string("answer_b");
            $table->string("answer_c");
            $table->string("answer_d");
            $table->string("good_answer");
            $table->string("status")->default(Suggestion::STATUS_PENDING);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("suggestions");
    }
}
