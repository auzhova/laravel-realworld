<?php

namespace App\Modules\Comments\Actions;

use App\Contracts\Services\CommentServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Comments\Requests\CreateComment;
use App\Modules\Comments\Responders\CommentCreateResponder;

class CommentCreateAction extends Controller
{
    private CommentServiceContract $service;
    protected CommentCreateResponder $responder;

    /**
     * CommentCreateAction constructor.
     *
     * @param CommentServiceContract $service
     * @param CommentCreateResponder $responder
     */
    public function __construct(CommentServiceContract $service, CommentCreateResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }
    public function __invoke(string $slug, CreateComment $createComment)
    {
        $comment = $this->service->create($slug, $createComment);
        return $this->responder->respond($comment);
    }
}
