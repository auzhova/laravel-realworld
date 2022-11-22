<?php

namespace App\Modules\Profiles\Actions;

use App\Contracts\Services\ProfileServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Profiles\Responders\ProfileUnfollowResponder;

class ProfileUnfollowAction extends Controller
{
    private ProfileServiceContract $service;
    protected ProfileUnfollowResponder $responder;

    /**
     * ProfileUnfollowAction constructor.
     *
     * @param ProfileServiceContract $service
     * @param ProfileUnfollowResponder $responder
     */
    public function __construct(ProfileServiceContract $service, ProfileUnfollowResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }
    public function __invoke(string $username)
    {
        $user = $this->service->unfollow($username);
        return $this->responder->respond($user);
    }
}
