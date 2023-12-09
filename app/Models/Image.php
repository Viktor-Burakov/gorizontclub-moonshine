<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';
    protected $guarded = [];

    public function categories(): MorphToMany
    {
        return $this->morphedByMany(Category::class, 'imageable');
    }

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'imageable');
    }

    public function contentBlocks(): MorphToMany
    {
        return $this->morphedByMany(ContentBlock::class, 'imageable');
    }
}
