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

//    public function categories()
//    {
//        return $this->belongsToMany(Categories::class, 'category_posts', 'post_id', 'category_id');
//    }

    public static $validData = array(
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
}
