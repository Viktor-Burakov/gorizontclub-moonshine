<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MoonShine\ChangeLog\Traits\HasChangeLog;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasChangeLog;

    protected $table = 'posts';
    protected $guarded = [];

    public static array $validData = array(
        'title' => 'string',
        'slug' => 'string',
        'date_start' => 'nullable|string',
        'date_end' => 'nullable|string',
        'preview_text' => 'nullable|string',
        'H1' => 'string',
        'preview' => 'nullable|string',
        'preview_alt' => 'nullable|string',
        'category' => '',
    );

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function contentBlocks(): MorphToMany
    {
        return $this->morphToMany(ContentBlock::class, 'content_blockable');
    }

    public function images(): MorphToMany
    {
        return $this->morphToMany(Image::class, 'imageable')
            ->orderByPivot('sort');
    }
}

