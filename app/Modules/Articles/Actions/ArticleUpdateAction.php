<?php

namespace App\Modules\Articles\Actions;

use App\Contracts\Services\ArticleServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Articles\Requests\UpdateArticle;
use App\Modules\Articles\Responders\ArticleUpdateResponder;

class ArticleUpdateAction extends Controller
{
    private ArticleServiceContract $service;
    protected ArticleUpdateResponder $responder;

    /**
     * ArticleUpdateAction constructor.
     *
     * @param ArticleServiceContract $service
     * @param ArticleUpdateResponder $responder
     */
    public function __construct(ArticleServiceContract $service, ArticleUpdateResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }
    public function __invoke(string $slug, UpdateArticle $updateArticle)
    {
        $article = $this->service->update($slug, $updateArticle);
        return $this->responder->respond($article);
    }
}
