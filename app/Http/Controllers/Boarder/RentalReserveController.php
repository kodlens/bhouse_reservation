<?php

namespace App\Http\Controllers\Boarder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rental;

class RentalReserveController extends Controller
{
    //

    public function index($id){

        $rental = Rental::find($id);
        return view('rental-reserve')
            ->with('rental', $rental);
    }


}
