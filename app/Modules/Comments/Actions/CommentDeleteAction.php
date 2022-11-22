<?php

namespace App\Modules\Comments\Actions;

use App\Contracts\Services\CommentServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Comments\Responders\CommentDeleteResponder;

class CommentDeleteAction extends Controller
{
    private CommentServiceContract $service;
    protected CommentDeleteResponder $responder;

    /**
     * CommentDeleteAction constructor.
     *
     * @param CommentServiceContract $service
     * @param CommentDeleteResponder $responder
     */
    public function __construct(CommentServiceContract $service, CommentDeleteResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }
    public function __invoke(string $slug, int $id)
    {
        $this->service->delete($slug, $id);
        return $this->responder->respond();
    }
}
