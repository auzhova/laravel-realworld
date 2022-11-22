<?php

namespace App\Services;

use App\Contracts\Services\TagServiceContract;
use App\Models\Tag;
use Illuminate\Support\Collection;

class TagService implements TagServiceContract
{
    public function list(): Collection
    {
        return Tag::all()->pluck('name');
    }
}
