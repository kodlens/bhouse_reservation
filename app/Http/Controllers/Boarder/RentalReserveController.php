<?php

namespace App\Http\Controllers\Boarder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rental;

use Auth;
use App\Models\Reservation;

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

        $user = Auth::user();
        $ref = strtoupper(substr(md5(time()), -6));

        Reservation::create([
            'reservation_ref' => $ref,
            'user_id' => $user->user_id,
            'rental_id' => $req->rental_id,
            'price' => $req->price,
            'book_datetime' => date('Y-m-d H:i:s'),
            'status' => 0,
        ]);


        $data = Rental::find($req->rental_id);
        $data->is_reserved = 1;
        $data->save();

        return response()->json([
            'status' => 'saved'
        ], 200);
    }


}
