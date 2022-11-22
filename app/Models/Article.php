<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property int    $id
 * @property int    $user_id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $body
 * @property User $user
 */

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'title', 'description', 'body'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'tags'
    ];

    /**
     * Получить список тегов статьи
     *
     * @return array
     */
    public function getTagListAttribute(): array
    {
        return $this->tags->pluck('name')->toArray();
    }

    /**
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLoadRelations($query)
    {
        return $query->with(['user.followers' => function ($query) {
            $query->where('follower_id', auth()->id());
        }])
            ->with(['favorited' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->withCount('favorited');
    }

    /**
     *
     * @return bool
     */
    public function getFavoritedAttribute()
    {
        if (! auth()->check()) {
            return false;
        }

        if (! $this->relationLoaded('favorited')) {
            $this->load(['favorited' => function ($query) {
                $query->where('user_id', auth()->id());
            }]);
        }

        $favorited = $this->getRelation('favorited');

        if (! empty($favorited) && $favorited->contains('id', auth()->id())) {
            return true;
        }

        return false;
    }

    /**
     *
     * @return integer
     */
    public function getFavoritesCountAttribute()
    {
        if (array_key_exists('favorited_count', $this->getAttributes())) {
            return $this->favorited_count;
        }

        return $this->favorited()->count();
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorited()
    {
        return $this->belongsToMany(User::class, 'favorites', 'article_id', 'user_id')->withTimestamps();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isFavoritedBy(User $user)
    {
        return !! $this->favorited()->where('user_id', $user->id)->count();
    }

    /**
     * Получить пользователя, которому принадлежит статья
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить все комментарии к статье
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
     * Получить все теги, которые относятся к статье
     *
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return string
     */
    public function getSlugSourceColumn(): string
    {
        return 'title';
    }

    /**
     * Получить список значений, которые не разрешены для статьи
     *
     * @return array
     */
    public function getBannedSlugValues(): array
    {
        return ['feed'];
    }

    public function slug($value): string
    {

        if (static::whereSlug($slug = Str::slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }

        return $slug;
    }

    public function incrementSlug($slug)
    {

        $original = $slug;

        $count = 2;

        while (static::whereSlug($slug)->exists()) {
            $slug = "{$original}-" . $count++;
        }

        return $slug;
    }
}
