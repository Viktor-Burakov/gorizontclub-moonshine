<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $active
 * @property string|null $url
 * @property string|null $title
 * @property string|null $h1
 * @property string|null $description
 * @property string|null $date_start
 * @property string|null $date_end
 * @property string|null $preview
 * @property string|null $preview_alt
 * @property string|null $preview_text
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContentBlock> $contentBlocks
 * @property-read int|null $content_blocks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Image> $images
 * @property-read int|null $images_count
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDateEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePreviewAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePreviewText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post withoutTrashed()
 * @mixin \Eloquent
 */
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

