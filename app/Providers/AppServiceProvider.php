<?php

namespace App\Providers;

use App\Contracts\Services\ArticleServiceContract;
use App\Contracts\Services\CommentServiceContract;
use App\Contracts\Services\ProfileServiceContract;
use App\Contracts\Services\TagServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Services\ArticleService;
use App\Services\CommentService;
use App\Services\ProfileService;
use App\Services\TagService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(TagServiceContract::class, TagService::class);
        $this->app->bind(ProfileServiceContract::class, ProfileService::class);
        $this->app->bind(ArticleServiceContract::class, ArticleService::class);
        $this->app->bind(CommentServiceContract::class, CommentService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
