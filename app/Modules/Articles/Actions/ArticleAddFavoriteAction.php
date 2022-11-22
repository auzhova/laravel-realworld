<?php

namespace App\Modules\Articles\Actions;

use App\Contracts\Services\ArticleServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Articles\Responders\ArticleAddFavoriteResponder;

class ArticleAddFavoriteAction extends Controller
{
    private ArticleServiceContract $service;
    protected ArticleAddFavoriteResponder $responder;

    /**
     * ArticleAddFavoriteAction constructor.
     *
     * @param ArticleServiceContract $service
     * @param ArticleAddFavoriteResponder $responder
     */
    public function __construct(ArticleServiceContract $service, ArticleAddFavoriteResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }

    public function __invoke(string $slug)
    {
        $article = $this->service->addFavorite($slug);
        return $this->responder->respond($article);
    }
}
