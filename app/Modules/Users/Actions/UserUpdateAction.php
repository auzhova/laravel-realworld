<?php

namespace App\Modules\Users\Actions;

use App\Contracts\Services\UserServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Users\Requests\UpdateUser;
use App\Modules\Users\Responders\UserUpdateResponder;

class UserUpdateAction extends Controller
{
    private UserServiceContract $service;
    protected UserUpdateResponder $responder;

    /**
     * UserUpdateAction constructor.
     *
     * @param UserServiceContract $service
     * @param UserUpdateResponder $responder
     */
    public function __construct(UserServiceContract $service, UserUpdateResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }
    public function __invoke(UpdateUser $updateUser)
    {
        $user = $this->service->update($updateUser);
        return $this->responder->respond($user);
    }
}
