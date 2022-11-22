<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;

class TestDataSeeder extends Seeder
{

    protected int $totalUsers = 15;

    protected int $totalTags = 10;

    protected float $userWithArticleRatio = 0.8;

    protected int $maxArticlesByUser = 10;

    protected int $maxArticleTags = 3;

    protected int $maxCommentsInArticle = 10;

    protected float $usersWithFavoritesRatio = 0.75;

    protected float $usersWithFollowingRatio = 0.75;

    public function run()
    {
        $users = User::factory()->count($this->totalUsers)->create();

        $tags = Tag::factory()->count($this->totalTags)->create();

        $users->random($this->totalUsers * $this->userWithArticleRatio)
            ->each(function ($user) use ($tags) {
                $articles = Article::factory()
                    ->count(rand(1, $this->maxArticlesByUser))
                    ->create(['user_id' => $user->id]);
                $user->articles()
                    ->saveMany($articles)
                    ->each(function ($article) use ($tags) {
                        $article->tags()->attach(
                            $tags->random(rand(1, min($this->maxArticleTags, $this->totalTags)))
                        );
                    })
                    ->each(function ($article) {
                        $comments = Comment::factory()
                            ->count(rand(1, $this->maxCommentsInArticle))
                            ->create(['article_id' => $article->id]);
                        $article->comments()
                            ->saveMany($comments);
                    });
            });

        $articles = Article::all();

        $users->random($users->count() * $this->usersWithFavoritesRatio)
            ->each(function ($user) use ($articles) {
                $articles->random(rand(1, $articles->count() * 0.5))
                    ->each(function ($article) use ($user) {
                        $user->favorite($article);
                    });
            });

        $users->random($users->count() * $this->usersWithFollowingRatio)
            ->each(function ($user) use ($users) {
                $users->except($user->id)
                    ->random(rand(1, ($users->count() - 1) * 0.2))
                    ->each(function ($userToFollow) use ($user) {
                        $user->follow($userToFollow);
                    });
            });
    }
}
