<?php

namespace App\Modules\Filemanager\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class WebController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
