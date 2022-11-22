<?php

namespace App\Modules\Tags\Actions;

use App\Contracts\Services\TagServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Tags\Responders\TagListResponder;

class TagListAction extends Controller
{
    private TagServiceContract $service;
    protected TagListResponder $responder;

    /**
     * TagListAction constructor.
     *
     * @param TagServiceContract $service
     */
    public function __construct(TagServiceContract $service, TagListResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        //$this->middleware('auth.api');
    }
    public function __invoke()
    {
        $tags = $this->service->list();
        return $this->responder->respond($tags);
    }
}
