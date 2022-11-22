<?php

namespace App\Contracts\Services;

use App\Models\User;

interface ProfileServiceContract
{
    public function show(string $username): User;

    public function follow(string $username): User;

    public function unfollow(string $username): User;
}
