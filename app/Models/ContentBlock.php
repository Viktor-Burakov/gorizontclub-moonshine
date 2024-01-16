<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MoonShine\ChangeLog\Traits\HasChangeLog;

class ContentBlock extends Model
{
    use HasFactory;
    use HasChangeLog;
    use SoftDeletes;
    protected $table = 'content_blocks';
    protected $guarded = [];

    public function categories(): MorphToMany
    {
        return $this->morphedByMany(Category::class, 'content_blockable');
    }

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'content_blockable');
    }

    public function images(): MorphToMany
    {
        return $this->morphToMany(Image::class, 'imageable');
    }
}
