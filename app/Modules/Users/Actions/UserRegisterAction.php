<?php

namespace App\Modules\Users\Actions;

use App\Contracts\Services\UserServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Users\Requests\RegisterUser;
use App\Modules\Users\Responders\UserRegisterResponder;

class UserRegisterAction extends Controller
{
    private UserServiceContract $service;
    protected UserRegisterResponder $responder;

    /**
     * UserRegisterAction constructor.
     *
     * @param UserServiceContract $service
     * @param UserRegisterResponder $responder
     */
    public function __construct(UserServiceContract $service, UserRegisterResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('guest');
    }
    public function __invoke(RegisterUser $registerUser)
    {
        $user = $this->service->register($registerUser);
        return $this->responder->respond($user);
    }
}
