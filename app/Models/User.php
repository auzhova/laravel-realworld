<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @property int    $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string|null $bio
 * @property string|null $image
 * @property string|null $remember_token
 * @property bool $following
 */

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'bio', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * @var mixed
     */
    private $favorited_count;

    /**
     * Установите пароль
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = (password_get_info($value)['algo'] === 0) ? bcrypt($value) : $value;
    }

    /**
     * Сгенерировать JWT token для пользователя
     *
     * @return string
     */
    public function getTokenAttribute(): string
    {
        return JWTAuth::fromUser($this);
    }

    /**
     * Получить все статьи пользователя
     *
     * @return HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class)->latest();
    }

    /**
     * Получить все комментарии пользователя
     *
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'username';
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     *
     * @param Article $article
     * @return void|null
     */
    public function favorite(Article $article)
    {
        if (! $this->hasFavorited($article)) {
            return $this->favorites()->attach($article);
        }
    }

    /**
     *
     * @param Article $article
     * @return int
     */
    public function unFavorite(Article $article): int
    {
        return $this->favorites()->detach($article);
    }

    /**
     *
     * @return BelongsToMany
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'favorites', 'user_id', 'article_id')->withTimestamps();
    }

    /**
     *
     * @param Article $article
     * @return bool
     */
    public function hasFavorited(Article $article): bool
    {
        return !! $this->favorites()->where('article_id', $article->id)->count();
    }


    /**
     *
     * @return bool
     */
    public function getFavoritedAttribute(): bool
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
     * @return int
     */
    public function getFavoritesCountAttribute(): int
    {
        if (array_key_exists('favorited_count', $this->getAttributes())) {
            return $this->favorited_count;
        }

        return $this->favorited()->count();
    }

    /**
     *
     * @return BelongsToMany
     */
    public function favorited(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites', 'article_id', 'user_id')->withTimestamps();
    }

    /**
     *
     * @param User $user
     * @return bool
     */
    public function isFavoritedBy(User $user): bool
    {
        return !! $this->favorited()->where('user_id', $user->id)->count();
    }

    /**
     *
     * @return bool
     */
    public function getFollowingAttribute(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        if (! $this->relationLoaded('followers')) {
            $this->load(['followers' => function ($query) {
                $query->where('follower_id', auth()->id());
            }]);
        }

        $followers = $this->getRelation('followers');

        if (! empty($followers) && $followers->contains('id', auth()->id())) {
            return true;
        }

        return false;
    }

    /**
     *
     * @param User $user
     * @return void|null
     */
    public function follow(User $user)
    {
        if (! $this->isFollowing($user) && $this->id != $user->id) {
            return $this->following()->attach($user);
        }
    }

    /**
     *
     * @param User $user
     * @return int
     */
    public function unFollow(User $user): int
    {
        return $this->following()->detach($user);
    }

    /**
     *
     * @return BelongsToMany
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')->withTimestamps();
    }

    /**
     *
     * @return BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id')->withTimestamps();
    }

    /**
     *
     * @param User $user
     * @return bool
     */
    public function isFollowing(User $user)
    {
        return !! $this->following()->where('followed_id', $user->id)->count();
    }

    /**
     *
     * @param User $user
     * @return bool
     */
    public function isFollowedBy(User $user)
    {
        return !! $this->followers()->where('follower_id', $user->id)->count();
    }
}
