<?php

namespace App\Modules\Users\Responders;

use App\Models\User;

class UserLogoutResponder
{
    public function respond(User $user): array
    {
        return [];
    }
}
