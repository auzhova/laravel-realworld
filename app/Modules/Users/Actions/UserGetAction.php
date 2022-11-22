<?php

namespace App\Modules\Users\Actions;

use App\Contracts\Services\UserServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Users\Responders\UserGetResponder;

class UserGetAction extends Controller
{
    private UserServiceContract $service;
    protected UserGetResponder $responder;

    /**
     * UserGetAction constructor.
     *
     * @param UserServiceContract $service
     * @param UserGetResponder $responder
     */
    public function __construct(UserServiceContract $service, UserGetResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }
    public function __invoke()
    {
        $user = $this->service->current();
        return $this->responder->respond($user);
    }
}
