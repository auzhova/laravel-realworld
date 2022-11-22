<?php

namespace App\Modules\Comments\Responders;

use App\Models\Comment;

class CommentCreateResponder
{
    public function respond(Comment $comment): array
    {
        return [
            'comment' => [
                'id'                => $comment['id'],
                'createdAt'         => $comment['created_at'],
                'updatedAt'         => $comment['updated_at'],
                'body'              => $comment['body'],
                'author' => [
                    'username'  => $comment['user']['username'],
                    'bio'       => $comment['user']['bio'],
                    'image'     => $comment['user']['image'],
                    'following' => $comment['user']['following'] ?? false,
                ]
            ]
        ];
    }
}
