<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoardingHouse;

use App\Models\AppointmentType;


class BhListController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(){
        return view('administrator.bh-lists');
    }


    public function getBhLists (Request $req){
        return BoardingHouse::with(['owner', 'province', 'city', 'barangay'])->paginate($req->perpage);
    }



    public function destroy($id){
        BoardingHouse::destroy($id);
    }


}
