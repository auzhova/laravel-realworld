<?php

namespace App\Contracts\Services;

use Illuminate\Support\Collection;

interface TagServiceContract
{
    public function list(): Collection;
}
