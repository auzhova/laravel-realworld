<?php

namespace App\Modules\Comments\Responders;

use Illuminate\Support\Collection;

class CommentShowResponder
{
    public function respond(Collection $comments): array
    {
        return [
            'comments' => array_map(function ($comment) {
                return [
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
                ];
            }, $comments->toArray())
        ];
    }
}
