<?php

namespace App\Modules\Articles\Actions;

use App\Contracts\Services\ArticleServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Articles\Requests\CreateArticle;
use App\Modules\Articles\Responders\ArticleCreateResponder;

class ArticleCreateAction extends Controller
{
    private ArticleServiceContract $service;
    protected ArticleCreateResponder $responder;

    /**
     * ArticleCreateAction constructor.
     *
     * @param ArticleServiceContract $service
     * @param ArticleCreateResponder $responder
     */
    public function __construct(ArticleServiceContract $service, ArticleCreateResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }
    public function __invoke(CreateArticle $createArticle)
    {
        $article = $this->service->create($createArticle);
        return $this->responder->respond($article);
    }
}
