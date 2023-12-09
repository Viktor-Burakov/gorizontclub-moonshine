<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MoonShine\ChangeLog\Traits\HasChangeLog;

class Category extends Model
{
    use HasFactory;
    use HasChangeLog;
    use SoftDeletes;
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
