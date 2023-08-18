<?php

namespace App\Http\Controllers\LandOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\BoardingHouse;

use Auth;

class LandownerDashboardController extends Controller
{
    //

    public function index(){
        $user = Auth::user();

        return view('landowner.landowner-dashboard')
            ->with('user', $user);
    }


    public function getLandOwnerBhouses(){
        $user = Auth::user();

        $bhouses = BoardingHouse::with(['amenities' => function($q){
            $q->with(['amenity'])->get();
        }, 'owner', 'province', 'city', 'barangay'])
            ->where('user_id', $user->user_id)
            ->get();
        return $bhouses;
    }



}
