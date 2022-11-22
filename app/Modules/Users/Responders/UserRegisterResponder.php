<?php

namespace App\Modules\Users\Responders;

use App\Models\User;

class UserRegisterResponder
{
    public function respond(User $user): array
    {
        return [
            'user' => [
                'username' => $user->username,
                'token' => $user->getTokenAttribute(),
                'email' => $user->email,
                'bio' => $user->bio,
                'image' => $user->image,
            ]
        ];
    }
}
