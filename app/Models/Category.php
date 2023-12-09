<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $guarded = [];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function contentBlocks(): MorphToMany
    {
        return $this->morphToMany(ContentBlock::class, 'content_blockable');
    }

    public function images(): MorphToMany
    {
        return $this->morphToMany(Image::class, 'imageable');
    }
}
