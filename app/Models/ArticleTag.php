<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id', 'tag_id'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'tags'
    ];
}
