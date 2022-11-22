<?php

namespace App\Modules\Articles\Responders;

use App\Models\Article;

class ArticleAddFavoriteResponder
{
    public function respond(Article $article): array
    {
        return [
            'article' => [
                'slug'              => $article['slug'],
                'title'             => $article['title'],
                'description'       => $article['description'],
                'body'              => $article['body'],
                'tagList'           => $article['tagList'] ?? [],
                'createdAt'         => $article['created_at'],
                'updatedAt'         => $article['updated_at'],
                'favorited'         => $article['favorited'] ?? [],
                'favoritesCount'    => $article['favoritesCount'] ?? 0,
                'author' => [
                    'username'  => $article['user']['username'],
                    'bio'       => $article['user']['bio'],
                    'image'     => $article['user']['image'],
                    'following' => $article['user']['following'] ?? false,
                ]
            ]
        ];
    }
}
