<?php

namespace App\Http\Controllers\LandOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }
}
