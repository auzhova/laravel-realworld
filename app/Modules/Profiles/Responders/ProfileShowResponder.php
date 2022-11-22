<?php

namespace App\Modules\Profiles\Responders;

use App\Models\User;

class ProfileShowResponder
{
    public function respond(User $user): array
    {
        return [
            'profile' => [
                'username' => $user->username,
                'bio' => $user->bio,
                'image' => $user->image,
                'following' => $user->following
            ]
        ];
    }
}
