<?php

namespace App\Modules\Comments\Actions;

use App\Contracts\Services\CommentServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Comments\Responders\CommentShowResponder;

class CommentShowAction extends Controller
{
    private CommentServiceContract $service;
    protected CommentShowResponder $responder;

    /**
     * CommentShowAction constructor.
     *
     * @param CommentServiceContract $service
     * @param CommentShowResponder $responder
     */
    public function __construct(CommentServiceContract $service, CommentShowResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }
    public function __invoke(string $slug)
    {
        $response = $this->service->show($slug);
        return $this->responder->respond($response);
    }
}

