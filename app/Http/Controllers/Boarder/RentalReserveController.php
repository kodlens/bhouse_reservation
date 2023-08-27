<?php

namespace App\Http\Controllers\Boarder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rental;

class RentalReserveController extends Controller
{
    //

    public function index($id){

        $rental = Rental::where('rental_id', $id)
            ->with(['rental_imgs'])
            ->first();
        return view('rental-reserve')
            ->with('rental', $rental);
    }

    public function rentalReserveNow(Request $req){

        return $req;
    }


}
