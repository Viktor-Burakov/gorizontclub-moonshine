<?php

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
        Schema::create('content_block_image', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('content_block_id');
            $table->unsignedBigInteger('image_id');

            $table->index('image_id', 'content_block_image_image_idx');
            $table->index('content_block_id', 'content_block_image_content_block_idx');

            $table->foreign('image_id', 'content_block_image_image_fk')
                ->references('id')
                ->on('images');
            $table->foreign('content_block_id', 'content_block_image_content_block_fk')
                ->references('id')
                ->on('content_blocks');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_block_image');
    }
};
