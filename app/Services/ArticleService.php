<?php

namespace App\Services;

use App\Contracts\Services\ArticleServiceContract;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use App\Modules\Articles\Requests\CreateArticle;
use App\Modules\Articles\Requests\FeedArticle;
use App\Modules\Articles\Requests\FilterArticle;
use App\Modules\Articles\Requests\UpdateArticle;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ArticleService implements ArticleServiceContract
{
    public function show(string $slug): Article
    {
        return Article::query()->loadRelations()->where('slug', $slug)->firstOrFail();
    }

    public function create(CreateArticle $createArticle): Article
    {
        $user = User::query()->find(Auth::id());

        $articleModel = new Article();
        $slug = $articleModel->slug($createArticle->input('article.title'));

        $article = $user->articles()->create([
            'slug' => $slug,
            'title' => $createArticle->input('article.title'),
            'description' => $createArticle->input('article.description'),
            'body' => $createArticle->input('article.body'),
        ]);

        $inputTags = $createArticle->input('article.tagList');

        if ($inputTags && !empty($inputTags)) {
            $tags = array_map(function ($name) {
                return Tag::firstOrCreate(['name' => $name])->id;
            }, $inputTags);

            $article->tags()->attach($tags);
        }

        return $article;
    }

    public function update(string $slug, UpdateArticle $updateArticle): Article
    {
        $user = User::query()->find(Auth::id());

        $article = $user->articles()->where('slug', $slug)->first();
        $article->update([
            'title' => $updateArticle->input('article.title'),
            'description' => $updateArticle->input('article.description'),
            'body' => $updateArticle->input('article.body'),
        ]);

        $article->refresh();

        return $article;
    }

    public function list(FilterArticle $filterArticle): Collection
    {
        $filter = $filterArticle->toArray();
        $limit = $filter['limit'] ?? 20;
        $offset = $filter['offset'] ?? 0;

        $query = Article::query()->loadRelations();

        if (isset($filter['tag'])) {
            $tag = Tag::where('name', $filter['tag'])->first();
            if ($tag) {
                $query = $query->whereIn('id', $tag->articles()->pluck('article_id')->toArray());
            }
        }

        if (isset($filter['author'])) {
            $author = User::where('username', $filter['author'])->first();
            if ($author) {
                $query = $query->where('user_id', $author->id);
            }
        }

        if (isset($filter['favorited'])) {
            $favorited = User::where('username', $filter['favorited'])->first();
            if ($favorited) {
                $query = $query->whereIn('id', $favorited->favorites()->pluck('id')->toArray());
            }
        }

        return collect([
            'total' => $query->count(),
            'articles' => $query->latest()->skip($offset)->take($limit)->get()
        ]);
    }

    public function feed(FeedArticle $feedArticle): Collection
    {
        $feed = $feedArticle->toArray();
        $limit = $feed['limit'] ?? 20;
        $offset = $feed['offset'] ?? 0;

        $user = User::query()->find(Auth::id());
        $followingIds = $user->following()->pluck('id')->toArray();
        $query = Article::query()->loadRelations()->whereIn('user_id', $followingIds);

        return collect([
            'total' => $query->count(),
            'articles' => $query->latest()->skip($offset)->take($limit)->get()
        ]);
    }

    public function delete(string $slug): void
    {
        $user = User::query()->find(Auth::id());
        $user->articles()->where('slug', $slug)->firstOrFail()->delete();
    }

    public function addFavorite(string $slug): Article
    {
        $user = User::query()->find(Auth::id());
        $article = Article::query()->loadRelations()->where('slug', $slug)->firstOrFail();
        $user->favorite($article);

        return $article->refresh();
    }

    public function removeFavorite(string $slug): Article
    {
        $user = User::query()->find(Auth::id());
        $article = Article::query()->loadRelations()->where('slug', $slug)->firstOrFail();
        dd($article);
        $user->unFavorite($article);

        return $article->refresh();
    }
}
