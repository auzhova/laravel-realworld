<?php

namespace App\Services;

use App\Contracts\Services\CommentServiceContract;
use App\Models\Article;
use App\Models\Comment;
use App\Modules\Comments\Requests\CreateComment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CommentService implements CommentServiceContract
{
    public function show(string $slug): Collection
    {
        $article = Article::query()->where('slug', $slug)->firstOrFail();
        return $article->comments()->get();
    }

    public function create(string $slug, CreateComment $createComment): Comment
    {
        $article = Article::query()->where('slug', $slug)->firstOrFail();
        $comment = $article->comments()->create([
            'body' => $createComment->input('comment.body'),
            'user_id' => Auth::id(),
        ]);
        return $comment;
    }

    public function delete(string $slug, int $id): void
    {
        $article = Article::query()->where('slug', $slug)->firstOrFail();
        $article->comments()->where('id', $id)->delete();
    }
}
