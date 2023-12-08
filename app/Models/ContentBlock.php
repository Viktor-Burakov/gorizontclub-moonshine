<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContentBlock
 *
 * @property int $id
 * @property string $name
 * @property string|null $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Database\Factories\ContentBlockFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ContentBlock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentBlock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentBlock query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentBlock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentBlock whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentBlock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentBlock whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentBlock whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentBlock whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
