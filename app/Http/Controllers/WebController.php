<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class WebController extends Controller
{
    /**
     * Отображение документации
     */
    public function docs()
    {
        return view('swagger.index');
    }
}
