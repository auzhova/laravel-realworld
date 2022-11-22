<?php

namespace App\Services;

use App\Contracts\Services\ProfileServiceContract;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileService implements ProfileServiceContract
{
    public function show(string $username): User
    {
        $user = User::query()->where('username', $username)->first();
        if (!$user) {
            abort(404, "User with username {$username} not found");
        }
        return $user;
    }

    public function follow(string $username): User
    {
        $followUser = $this->show($username);
        $user = User::query()->find(Auth::id());
        $user->follow($followUser);
        $user->refresh();
        return $user;
    }

    public function unfollow(string $username): User
    {
        $followUser = $this->show($username);
        $user = User::query()->find(Auth::id());
        $user->unFollow($followUser);
        $user->refresh();
        return $user;
    }
}
