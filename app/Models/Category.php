<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $active
 * @property string $url
 * @property string $title
 * @property string|null $description
 * @property string|null $preview
 * @property string|null $preview_alt
 * @property string|null $preview_text
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category wherePreviewAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category wherePreviewText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUrl($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $guarded = [];

    public function posts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'category_posts', 'category_id', 'post_id');
    }
}
