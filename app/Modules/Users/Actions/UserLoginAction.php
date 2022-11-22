<?php

namespace App\Modules\Users\Actions;

use App\Contracts\Services\UserServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Users\Requests\LoginUser;
use App\Modules\Users\Responders\UserLoginResponder;

class UserLoginAction extends Controller
{
    private UserServiceContract $service;
    protected UserLoginResponder $responder;

    /**
     * UserLoginAction constructor.
     *
     * @param UserServiceContract $service
     * @param UserLoginResponder $responder
     */
    public function __construct(UserServiceContract $service, UserLoginResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('guest');
    }
    public function __invoke(LoginUser $loginUser)
    {
        $user = $this->service->login($loginUser);
        return $this->responder->respond($user);
    }
}
