<?php

namespace App\Modules\Profiles\Actions;

use App\Contracts\Services\ProfileServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Profiles\Responders\ProfileFollowResponder;

class ProfileFollowAction extends Controller
{
    private ProfileServiceContract $service;
    protected ProfileFollowResponder $responder;

    /**
     * ProfileFollowAction constructor.
     *
     * @param ProfileServiceContract $service
     * @param ProfileFollowResponder $responder
     */
    public function __construct(ProfileServiceContract $service, ProfileFollowResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }
    public function __invoke(string $username)
    {
        $user = $this->service->follow($username);
        return $this->responder->respond($user);
    }
}
