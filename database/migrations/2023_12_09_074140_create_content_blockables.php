<?php

use App\Models\ContentBlock;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('content_blockables', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(ContentBlock::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->morphs('content_blockable');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_blockables');
    }
};
