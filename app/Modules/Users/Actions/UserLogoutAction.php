<?php

namespace App\Modules\Users\Actions;

use App\Contracts\Services\UserServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Users\Responders\UserLogoutResponder;

class UserLogoutAction extends Controller
{
    private UserServiceContract $service;
    protected UserLogoutResponder $responder;

    /**
     * UserLogoutAction constructor.
     *
     * @param UserServiceContract $service
     * @param UserLogoutResponder $responder
     */
    public function __construct(UserServiceContract $service, UserLogoutResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }
    public function __invoke()
    {
        $user = $this->service->logout();
        return $this->responder->respond($user);
    }
}
