<?php

namespace App\Contracts\Services;

use App\Models\Comment;
use App\Modules\Comments\Requests\CreateComment;
use Illuminate\Database\Eloquent\Collection;

interface CommentServiceContract
{
    public function show(string $slug): Collection;

    public function create(string $slug, CreateComment $comment): Comment;

    public function delete(string $slug, int $id): void;
}
