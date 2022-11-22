<?php

namespace App\Modules\Articles\Actions;

use App\Contracts\Services\ArticleServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Articles\Requests\FilterArticle;
use App\Modules\Articles\Responders\ArticleListResponder;

class ArticleListAction extends Controller
{
    private ArticleServiceContract $service;
    protected ArticleListResponder $responder;

    /**
     * ArticleListAction constructor.
     *
     * @param ArticleServiceContract $service
     * @param ArticleListResponder $responder
     */
    public function __construct(ArticleServiceContract $service, ArticleListResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        //$this->middleware('auth.api');
    }
    public function __invoke(FilterArticle $filterArticle)
    {
        $response = $this->service->list($filterArticle);
        return $this->responder->respond($response);
    }
}
