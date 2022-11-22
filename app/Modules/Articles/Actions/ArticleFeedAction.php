<?php

namespace App\Modules\Articles\Actions;

use App\Contracts\Services\ArticleServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Articles\Requests\FeedArticle;
use App\Modules\Articles\Responders\ArticleFeedResponder;

class ArticleFeedAction extends Controller
{
    private ArticleServiceContract $service;
    protected ArticleFeedResponder $responder;

    /**
     * ArticleFeedAction constructor.
     *
     * @param ArticleServiceContract $service
     * @param ArticleFeedResponder $responder
     */
    public function __construct(ArticleServiceContract $service, ArticleFeedResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }
    public function __invoke(FeedArticle $feedArticle)
    {
        $response = $this->service->feed($feedArticle);
        return $this->responder->respond($response);
    }
}
