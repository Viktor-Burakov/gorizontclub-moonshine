<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'posts';
    protected $guarded = [];

    public static array $validData = array(
        'title' => 'string',
        'url' => 'string',
        'date_start' => 'nullable|string',
        'date_end' => 'nullable|string',
        'preview_text' => 'nullable|string',
        'H1' => 'string',
        'preview' => 'nullable|string',
        'preview_alt' => 'nullable|string',
        'category' => '',
    );



    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_posts', 'post_id', 'category_id');
    }

    public function contentBlocks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ContentBlock::class, 'content_block_post', 'post_id', 'content_block_id');
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'image_post', 'post_id', 'image_id');
    }
}

