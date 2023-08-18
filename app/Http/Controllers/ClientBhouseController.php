<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\BoardingHouse;

class ClientBhouseController extends Controller
{
    //

    public function __construct(){

    }

    public function getBhouses(Request $req){

        //return $req;

        $amenities = json_decode($req->amenities);
        $rules = json_decode($req->rules);
        //return $amenities;


        //$arr_amenities = [];

//        foreach ($req->amenities as $i){
//            //array_push($arr_amenities, $i);
//            return $i;
//        }



        $room_type = $req->room_type;
        $price_min = $req->min_price;
        $price_max = $req->max_price;
        $bhousename = $req->bhousename;
        //$bhouserule = $req->bhouserule;

        $prov = $req->province;
        $city = $req->city;
        $brgy = $req->barangay;
        $street = $req->street;

        //return $amenities;

        //return $req;

        $data = BoardingHouse::with(['province', 'city', 'barangay', 'amenities', 'rooms', 'bedspaces', 'rules'])
            ->where('bhouse_name', 'like', '%' .$bhousename .'%')
            ->wherehas('rooms', function ($q) use ($room_type){
                $q->where('room_type', 'like', $room_type . '%');
            })
            ->wherehas('province', function ($q) use ($prov){
                $q->where('provCode', 'like', $prov . '%');
            })
            ->wherehas('city', function ($q) use ($city){
                $q->where('citymunCode', 'like', $city . '%');
            })
            ->wherehas('barangay', function ($q) use ($brgy){
                $q->where('brgyCode', 'like', $brgy . '%');
            })
            ->where('street', 'like', '%' . $street .'%')

            ->wherehas('bedspaces', function ($q) use ($price_min, $price_max){
                $q->whereBetween('price', [$price_min, $price_max]);
            });


        if(!empty($amenities)){
            $data->whereHas('amenities', function ($q) use ($amenities){
                $q->whereIn('amenity_id', $amenities);
            });
        }

        if(!empty($rules)){
            $data->whereHas('rules', function ($q) use ($rules){
                $q->whereIn('rule_id', $rules);
            });
        }


//        if($amenities){
//            $data = BoardingHouse::with(['province', 'city', 'barangay', 'amenities', 'rooms', 'bedspaces', 'rules'])
//                ->where('bhouse_name', 'like', '%' .$bhousename .'%')
//                //->where('bhouse_rule', 'like', '%' . $bhouserule .'%')
//                ->wherehas('amenities', function ($q) use ($amenities){
//                    $q->whereIn('amenity_id', $amenities);
//                })
//                ->wherehas('rooms', function ($q) use ($room_type){
//                    $q->where('room_type', 'like', $room_type . '%');
//                })
//
//                ->wherehas('province', function ($q) use ($prov){
//                    $q->where('provCode', 'like', $prov . '%');
//                })
//                ->wherehas('city', function ($q) use ($city){
//                    $q->where('citymunCode', 'like', $city . '%');
//                })
//                ->wherehas('barangay', function ($q) use ($brgy){
//                    $q->where('brgyCode', 'like', $brgy . '%');
//                })
//                ->where('street', 'like', '%' . $street .'%')
//
//                ->wherehas('bedspaces', function ($q) use ($price_min, $price_max){
//                    $q->whereBetween('price', [$price_min, $price_max]);
//                })
//                ->get();
//        }else{
//            $data = BoardingHouse::with(['province', 'city', 'barangay', 'amenities', 'rooms', 'bedspaces', 'rules'])
//                ->where('bhouse_name', 'like', '%' .$bhousename .'%')
//                //->where('bhouse_rule', 'like', '%' . $bhouserule .'%')
//                ->wherehas('rooms', function ($q) use ($room_type){
//                    $q->where('room_type', 'like', $room_type . '%');
//                })
//
//                ->wherehas('province', function ($q) use ($prov){
//                    $q->where('provCode', 'like', $prov . '%');
//                })
//                ->wherehas('city', function ($q) use ($city){
//                    $q->where('citymunCode', 'like', $city . '%');
//                })
//                ->wherehas('barangay', function ($q) use ($brgy){
//                    $q->where('brgyCode', 'like', $brgy . '%');
//                })
//                ->where('street', 'like', '%' . $street .'%')
//                ->wherehas('bedspaces', function ($q) use ($price_min, $price_max){
//                    $q->whereBetween('price', [$price_min, $price_max]);
//                })
//                ->get();
//        }


        return $data->get();
    }


    public function showBhouseDetail($id){

//        $data = DB::table('boarding_houses as a')
//            ->join('users as b', 'a.user_id', 'b.user_id')
//            ->join('provinces as c', 'a.province', 'c.provCode')
//            ->join('cities as d', 'a.city', 'd.citymunCode')
//            ->join('barangays as e', 'a.barangay', 'e.brgyCode')
//            ->where('a.bhouse_id', $id)
//            ->select('a.*', 'b.lname', 'b.fname', 'b.mname', 'b.contact_no', 'c.*', 'd.*', 'e.*')
//            ->get();


        $data = BoardingHouse::with(['province', 'city', 'barangay', 'amenities', 'owner', 'rules'])
            ->where('bhouse_id', $id)
            ->get();

            //return $data;

        //$data = BoardingHouse::find($id);
        return view('client-bhouse-detail')->with('id', $id)
            ->with('data', $data);
    }

    public function getBhouseDetail($id){
        $data = DB::table('boarding_houses as a')
            ->join('users as b', 'a.user_id', 'b.user_id')
            ->join('provinces as c', 'a.province', 'c.provCode')
            ->join('cities as d', 'a.city', 'd.citymunCode')
            ->join('barangays as e', 'a.barangay', 'e.brgyCode')
            ->where('a.bhouse_id', $id)
            ->select('a.*', 'b.lname', 'b.fname', 'b.mname', 'b.contact_no', 'c.*', 'd.*', 'e.*')
            ->get();
        return $data[0];
    }
}
