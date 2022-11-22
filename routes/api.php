<?php

use App\Modules\Articles\Actions\ArticleAddFavoriteAction;
use App\Modules\Articles\Actions\ArticleRemoveFavoriteAction;
use App\Modules\Articles\Actions\ArticleCreateAction;
use App\Modules\Articles\Actions\ArticleDeleteAction;
use App\Modules\Articles\Actions\ArticleFeedAction;
use App\Modules\Articles\Actions\ArticleListAction;
use App\Modules\Articles\Actions\ArticleShowAction;
use App\Modules\Articles\Actions\ArticleUpdateAction;
use App\Modules\Comments\Actions\CommentCreateAction;
use App\Modules\Comments\Actions\CommentDeleteAction;
use App\Modules\Comments\Actions\CommentShowAction;
use App\Modules\Profiles\Actions\ProfileFollowAction;
use App\Modules\Profiles\Actions\ProfileShowAction;
use App\Modules\Profiles\Actions\ProfileUnfollowAction;
use App\Modules\Users\Actions\UserGetAction;
use App\Modules\Users\Actions\UserLoginAction;
use App\Modules\Users\Actions\UserLogoutAction;
use App\Modules\Users\Actions\UserRegisterAction;
use App\Modules\Users\Actions\UserUpdateAction;
use Illuminate\Support\Facades\Route;
use App\Modules\Tags\Actions\TagListAction;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('users', UserRegisterAction::class);
Route::post('users/login', UserLoginAction::class);
Route::post('users/logout', UserLogoutAction::class);

Route::get('user', UserGetAction::class);
Route::match('put', 'user', UserUpdateAction::class);

Route::get('profiles/{username}', ProfileShowAction::class)->where('username', '^[a-zA-Z0-9-.]+$');
Route::post('profiles/{username}/follow', ProfileFollowAction::class)->where('username', '^[a-zA-Z0-9-.]+$');
Route::delete('profiles/{username}/follow', ProfileUnfollowAction::class)->where('username', '^[a-zA-Z0-9-.]+$');

Route::get('articles', ArticleListAction::class);
Route::post('articles', ArticleCreateAction::class);
Route::post('articles/feed', ArticleFeedAction::class);
Route::post('article/{slug}/favorite', ArticleAddFavoriteAction::class)->where('slug', '^[a-zA-Z0-9-]+$');
Route::delete('article/{slug}/favorite', ArticleRemoveFavoriteAction::class)->where('slug', '^[a-zA-Z0-9-]+$');
Route::get('article/{slug}/comments', CommentShowAction::class)->where('slug', '^[a-zA-Z0-9-]+$');
Route::post('article/{slug}/comments', CommentCreateAction::class)->where('slug', '^[a-zA-Z0-9-]+$');
Route::delete('article/{slug}/comments/{id}', CommentDeleteAction::class)->where('slug', '^[a-zA-Z0-9-]+$');
Route::get('article/{slug}', ArticleShowAction::class)->where('slug', '^[a-zA-Z0-9-]+$');
Route::put('article/{slug}', ArticleUpdateAction::class)->where('slug', '^[a-zA-Z0-9-]+$');
Route::delete('article/{slug}', ArticleDeleteAction::class)->where('slug', '^[a-zA-Z0-9-]+$');

Route::get('tags', TagListAction::class);
