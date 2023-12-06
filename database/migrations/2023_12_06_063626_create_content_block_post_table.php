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
        Schema::create('content_block_post', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('content_block_id');
            $table->unsignedBigInteger('post_id');

            $table->index('post_id', 'content_block_post_post_idx');
            $table->index('content_block_id', 'content_block_post_content_block_idx');

            $table->foreign('post_id', 'content_block_post_post_fk')
                ->references('id')
                ->on('posts');
            $table->foreign('content_block_id', 'content_block_post_content_block_fk')
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
        Schema::dropIfExists('content_block_post');
    }
};
