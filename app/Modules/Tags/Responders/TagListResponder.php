<?php

namespace App\Modules\Tags\Responders;

use Illuminate\Support\Collection;

class TagListResponder
{
    public function respond(Collection $tags): Collection
    {
        return $tags;
    }
}
