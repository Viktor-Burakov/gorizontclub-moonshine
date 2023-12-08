<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ContentBlock extends Model
{
    use HasFactory;
    protected $table = 'content_blocks';
    protected $guarded = [];

    public function posts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'content_block_post', 'content_block_id', 'post_id');
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'content_block_image', 'content_block_id', 'image_id');
    }
}
