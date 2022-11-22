<?php

namespace App\Contracts\Services;

use App\Models\Article;
use App\Modules\Articles\Requests\CreateArticle;
use App\Modules\Articles\Requests\FeedArticle;
use App\Modules\Articles\Requests\FilterArticle;
use App\Modules\Articles\Requests\UpdateArticle;
use Illuminate\Support\Collection;

interface ArticleServiceContract
{
    public function show(string $slug): Article;

    public function create(CreateArticle $article): Article;

    public function update(string $slug, UpdateArticle $article): Article;

    public function list(FilterArticle $filter): Collection;

    public function feed(FeedArticle $feed): Collection;

    public function delete(string $slug): void;

    public function addFavorite(string $slug): Article;

    public function removeFavorite(string $slug): Article;
}
