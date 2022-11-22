<?php

namespace App\Modules\Articles\Actions;

use App\Contracts\Services\ArticleServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Articles\Requests\CreateArticle;
use App\Modules\Articles\Responders\ArticleAddFavoriteResponder;
use App\Modules\Articles\Responders\ArticleCreateResponder;

class ArticleRemoveFavoriteAction extends Controller
{
    private ArticleServiceContract $service;
    protected ArticleRemoveFavoriteAction $responder;

    /**
     * ArticleAddFavoriteAction constructor.
     *
     * @param ArticleServiceContract $service
     * @param ArticleRemoveFavoriteAction $responder
     */
    public function __construct(ArticleServiceContract $service, ArticleRemoveFavoriteAction $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }
    public function __invoke(string $slug)
    {
        $article = $this->service->removeFavorite($slug);
        return $this->responder->respond($article);
    }
}
