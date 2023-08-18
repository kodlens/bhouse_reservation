<?php

namespace App\Http\Controllers\LandOwner;

use App\Http\Controllers\Controller;
use App\Models\BhouseAmenity;
use App\Models\BoardingHouse;
use App\Models\BoardingHouseRule;
use Illuminate\Http\Request;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;


use Auth;

class LandownerBoardingHouseController extends Controller
{
    //
    public function index(){
        $user = Auth::user();

        return view('landowner.boarding-house')
            ->with('user', $user);
    }

    public function show($id){

        return BoardingHouse::find($id);
    }


    public function getBoardingHouses(Request $req){

        $id = Auth::user()->user_id;

        return BoardingHouse::with(['rooms', 'rooms.bedspaces'])
            ->where('user_id', $id)
            ->where('bhouse_name', 'like', $req->bhousename . '%')
            ->orderBy('bhouse_id', 'desc')
            ->get();
    }

    public function create(){
        return view('landowner.boarding-house-create');
    }

    public function store(Request $req){

        $validate = $req->validate([
            'bhouse_name' => ['required', 'string', 'max: 100'],
            'contact_person' => ['required'],
            'contact_no' => ['required'],
            'rules' => ['required'],
            'bhouse_img_path' => ['required', 'mimes:jpg,png,bmp'],
            'long' => ['required'],
            'amenities' => ['required'],
            'lat' => ['required'],
            'province' => ['required'],
            'city' => ['required'],
            'barangay' => ['required'],
            'street' => ['required'],
        ], $message = [
            'bhouse_img_path.mimes' => 'Type of the file must be jpg, png or bmp.',
            'bhouse_img_path.required' => 'Image is required.',
            'rules.required' => 'Please select atleast one boarding house rules.'
        ]);


        $userid = Auth::user()->user_id;

        $bhouseImg = null;
        //upload image b house
        $bhouseImg = $req->file('bhouse_img_path');
        if($bhouseImg){
            $pathFile = $bhouseImg->store('public/bhouses'); //get path of the file
            $bhousePath = explode('/', $pathFile); //split into array using /
        }

        $data = BoardingHouse::create([
            'bhouse_name' => strtoupper($req->bhouse_name),
            'user_id' => $userid,
            'contact_person' => strtoupper($req->contact_person),
            'contact_no' => $req->contact_no,
            'bhouse_rule' => $req->bhouse_rule,
            'bhouse_desc' => $req->bhouse_desc,
            'bhouse_img_path' => $bhousePath[2] != null ? $bhousePath[2]: '',
            'long' => $req->long,
            'lat' => $req->lat,
            'province' => strtoupper($req->province),
            'city' => strtoupper($req->city),
            'barangay' => strtoupper($req->barangay),
            'street' => strtoupper($req->street),
        ]);

        foreach($req->amenities as $item){
            BhouseAmenity::create([
                'bhouse_id' => $data->bhouse_id,
                'amenity_id' => $item
            ]);
        }

        foreach($req->rules as $item){
            BoardingHouseRule::create([
                'bhouse_id' => $data->bhouse_id,
                'rule_id' => $item
            ]);
        }


        return response()->json([
            'status' => 'saved'
        ], 200);
    }


    public function edit($id){
        $bhouse = BoardingHouse::with(['amenities', 'rules'])->find($id);

        return view('landowner.boarding-house-create')
            ->with('bhouse', $bhouse)
            ->with('id', $id);
    }

    public function update(Request $req, $id){

        $validate = $req->validate([
            'bhouse_name' => ['required', 'string', 'max: 100'],
            'contact_person' => ['required'],
            'contact_no' => ['required'],
            'rules' => ['required'],
            'amenities' => ['required'],
            'long' => ['required'],
            'lat' => ['required'],
            'province' => ['required'],
            'city' => ['required'],
            'barangay' => ['required'],
            'street' => ['required'],
        ],[
            'rules.required' => 'Please select atleast one boarding house rules.'
        ]);

        //return $req;

        $data = BoardingHouse::find($id);
        $bhouseImg = null;
        //upload image b house

        $bhouseImg = $req->file('bhouse_img_path');
        if($bhouseImg){
            //check the file and delete to update
            if(Storage::exists('public/bhouses/' .$data->bhouse_img_path)) {
                Storage::delete('public/bhouses/' . $data->bhouse_img_path);
            }
            $pathFile = $bhouseImg->store('public/bhouses'); //get path of the file
            $bhousePath = explode('/', $pathFile); //split into array using /
        }

        $data->bhouse_name = strtoupper($req->bhouse_name);
        $data->contact_person = strtoupper($req->contact_person);
        $data->contact_no = $req->contact_no;
        $data->bhouse_rule = $req->bhouse_rule;
        $data->bhouse_desc = $req->bhouse_desc;

        if($bhouseImg){
            $data->bhouse_img_path = $bhousePath[2];
        }

        $data->long = strtoupper($req->long);
        $data->lat = strtoupper($req->lat);

        $data->province = strtoupper($req->province);
        $data->city = strtoupper($req->city);
        $data->barangay = strtoupper($req->barangay);
        $data->street = strtoupper($req->street);
        $data->save();


        //insert update or delete amenities
        if($req->amenities){
            foreach($req->amenities as $item){
                BhouseAmenity::updateOrCreate(
                    [ 'bhouse_id' => $id, 
                        'amenity_id' => $item ],
                    [
                        'bhouse_id' => $id, 
                        'amenity_id' => $item
                    ]
                );
            }

            $bhouseAmenities = BhouseAmenity::where('bhouse_id', $id)->get();
            foreach($bhouseAmenities as $amenity){
                if(!in_array($amenity->amenity_id, $req->amenities)){
                    BhouseAmenity::where('amenity_id',$amenity->amenity_id)
                        ->where('bhouse_id', $id)
                        ->delete();
                }
            }
        }else{
            //if wala amenities, delete all amenities
            BhouseAmenity::where('bhouse_id', $id)
                ->delete();
        }

        //insert update or delete rules
        if($req->rules){
            foreach($req->rules as $item){
                BoardingHouseRule::updateOrCreate(
                    [
                        'bhouse_id' => $id,
                        'rule_id' => $item ],
                    [
                        'bhouse_id' => $id,
                        'rule_id' => $item
                    ]
                );
            }

            $bhouseRules = BoardingHouseRule::where('bhouse_id', $id)->get();
            foreach($bhouseRules as $rule){
                if(!in_array($rule->rule_id, $req->rules)){
                    BoardingHouseRule::where('rule_id',$rule->rule_id)
                        ->where('bhouse_id', $id)
                        ->delete();
                }
            }

        }else{
            //if wala amenities, delete all amenities
            BoardingHouseRule::where('bhouse_id', $id)
                ->delete();
        }


        return response()->json([
            'status' => 'updated'
        ], 200);
    }



    public function destroy($id){
        $data = BoardingHouse::find($id);
        if(Storage::exists('public/bhouses/' .$data->bhouse_img_path)) {
            Storage::delete('public/bhouses/' . $data->bhouse_img_path);
        }
        BoardingHouse::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ]);
    }



}
