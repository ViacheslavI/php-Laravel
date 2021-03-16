<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;

    const UNKNOWN_USER =1;

    protected $fillable =[
        'title',
        'slug',
        'category_id',
        'excerpt',
        'content_raw',
        'is_published',
        'published_at',

    ];
    /**
    *категория статьи
    */
    public function category()
    {
        /**
         *статья принадлежит категории
         */
        return  $this->belongsTo(BlogCategory::class);
    }

    public function user()
    {
        /**
         *статья принадлежит пользователю
         */

        return $this->belongsTo(User::class);
    }

}
