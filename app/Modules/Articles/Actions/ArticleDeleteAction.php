<?php

namespace App\Modules\Articles\Actions;

use App\Contracts\Services\ArticleServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Articles\Responders\ArticleDeleteResponder;

class ArticleDeleteAction extends Controller
{
    private ArticleServiceContract $service;
    protected ArticleDeleteResponder $responder;

    /**
     * ArticleDeleteAction constructor.
     *
     * @param ArticleServiceContract $service
     * @param ArticleDeleteResponder $responder
     */
    public function __construct(ArticleServiceContract $service, ArticleDeleteResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }
    public function __invoke(string $slug)
    {
        $this->service->delete($slug);
        return $this->responder->respond();
    }
}
