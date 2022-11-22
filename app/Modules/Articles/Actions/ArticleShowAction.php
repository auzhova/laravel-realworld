<?php

namespace App\Modules\Articles\Actions;

use App\Contracts\Services\ArticleServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Articles\Responders\ArticleShowResponder;

class ArticleShowAction extends Controller
{
    private ArticleServiceContract $service;
    protected ArticleShowResponder $responder;

    /**
     * ArticleShowAction constructor.
     *
     * @param ArticleServiceContract $service
     * @param ArticleShowResponder $responder
     */
    public function __construct(ArticleServiceContract $service, ArticleShowResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        //$this->middleware('auth.api');
    }
    public function __invoke(string $slug)
    {
        $article = $this->service->show($slug);
        return $this->responder->respond($article);
    }
}
