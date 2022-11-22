<?php

namespace App\Services;

use App\Contracts\Services\TagServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Models\Tag;
use App\Models\User;
use App\Modules\Users\Requests\LoginUser;
use App\Modules\Users\Requests\RegisterUser;
use App\Modules\Users\Requests\UpdateUser;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceContract
{
    public function register(RegisterUser $registerUser): User
    {
        $data = $registerUser->get('user');

        return DB::transaction(function () use ($data) {
            $user = new User();
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);

            $user->save();
            return $user;
        });
    }

    public function login(LoginUser $loginUser): User
    {
        $data = $loginUser->get('user');

        if (Auth::attempt($data)) {
            return User::query()->where('email', $data['email'])->first();
        } else {
            abort(401, 'Invalid email or password');
        }
    }

    public function update(UpdateUser $updateUser): User
    {
        $data = $updateUser->get('user');

        return DB::transaction(function () use ($data) {
            $user = Auth::user();
            if (isset($data['username'])) {
                $user->username = $data['username'];
            }
            if (isset($data['email'])) {
                $user->email = $data['email'];
            }
            if (isset($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            if (isset($data['bio'])) {
                $user->bio = $data['bio'];
            }
            if (isset($data['image'])) {
                $user->image = $data['image'];
            }
            $user->save();
            return $user;
        });
    }

    public function logout(): User
    {
        $user = Auth::user();
        Auth::logout();
        return $user;
    }

    public function current(): User
    {
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        return $user;
    }
}
