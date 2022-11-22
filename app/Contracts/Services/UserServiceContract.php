<?php

namespace App\Contracts\Services;

use App\Models\User;
use App\Modules\Users\Requests\LoginUser;
use App\Modules\Users\Requests\RegisterUser;
use App\Modules\Users\Requests\UpdateUser;

interface UserServiceContract
{
    public function register(RegisterUser $registerUser): User;

    public function login(LoginUser $loginUser): User;

    public function update(UpdateUser $updateUser): User;

    public function current(): User;

    public function logout(): User;
}
