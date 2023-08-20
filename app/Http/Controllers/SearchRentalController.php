<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;


class SearchRentalController extends Controller
{
    //

    public function index(){
        return view('search-boarding-houses');
    }

    public function getSearchBhouses(Request $req){

        //return $req;

        $amenities = json_decode($req->amenities);
        $rules = json_decode($req->rules);
        //return $amenities;


        //$arr_amenities = [];
//        foreach ($req->amenities as $i){
//            //array_push($arr_amenities, $i);
//            return $i;
//        }

        $rental_type = $req->rental_type;
        $price_min = $req->min_price;
        $price_max = $req->max_price;
        //$bhouserule = $req->bhouserule;

        $prov = $req->province;
        $city = $req->city;
        $brgy = $req->barangay;
        $street = $req->street;

        //return $amenities;
        //return $req;

        $data = Rental::with([
            'boardingHouse.province', 
            'boardingHouse.city', 
            'boardingHouse.barangay', 
            'boardingHouse.amenities',
            'boardingHouse.rules'])
           
            ->where('rental_type', 'like', $rental_type . '%')
            ->wherehas('boardingHouse.province', function ($q) use ($prov){
                $q->where('provCode', 'like', $prov . '%');
            })
            ->wherehas('boardingHouse.city', function ($q) use ($city){
                $q->where('citymunCode', 'like', $city . '%');
            })
            ->wherehas('boardingHouse.barangay', function ($q) use ($brgy){
                $q->where('brgyCode', 'like', $brgy . '%');
            });

        if(!empty($amenities)){
            $data->whereHas('boardingHouse.amenities', function ($q) use ($amenities){
                $q->whereIn('amenity_id', $amenities);
            });
        }
        if(!empty($rules)){
            $data->whereHas('boardingHouse.rules', function ($q) use ($rules){
                $q->whereIn('rule_id', $rules);
            });
        }

//        if($amenities){
//            $data = BoardingHouse::with(['province', 'city', 'barangay', 'amenities', 'rentals', 'bedspaces', 'rules'])
//                ->where('bhouse_name', 'like', '%' .$bhousename .'%')
//                //->where('bhouse_rule', 'like', '%' . $bhouserule .'%')
//                ->wherehas('amenities', function ($q) use ($amenities){
//                    $q->whereIn('amenity_id', $amenities);
//                })
//                ->wherehas('rentals', function ($q) use ($rental_type){
//                    $q->where('rental_type', 'like', $rental_type . '%');
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
//            $data = BoardingHouse::with(['province', 'city', 'barangay', 'amenities', 'rentals', 'bedspaces', 'rules'])
//                ->where('bhouse_name', 'like', '%' .$bhousename .'%')
//                //->where('bhouse_rule', 'like', '%' . $bhouserule .'%')
//                ->wherehas('rentals', function ($q) use ($rental_type){
//                    $q->where('rental_type', 'like', $rental_type . '%');
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
}
