<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Получить все статьи, которые относятся к тегу
     *
     * @return BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class)->latest();
    }
}
