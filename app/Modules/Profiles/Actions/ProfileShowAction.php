<?php

namespace App\Modules\Profiles\Actions;

use App\Contracts\Services\ProfileServiceContract;
use App\Http\Controllers\Controller;
use App\Modules\Profiles\Responders\ProfileShowResponder;
use Symfony\Component\HttpFoundation\Request;

class ProfileShowAction extends Controller
{
    private ProfileServiceContract $service;
    protected ProfileShowResponder $responder;

    /**
     * ProfileShowAction constructor.
     *
     * @param ProfileServiceContract $service
     * @param ProfileShowResponder $responder
     */
    public function __construct(ProfileServiceContract $service, ProfileShowResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;

        $this->middleware('auth.api');
    }
    public function __invoke(string $username)
    {
        $user = $this->service->show($username);
        return $this->responder->respond($user);
    }
}
