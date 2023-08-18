<?php

namespace App\Http\Controllers\LandOwner;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


use Auth;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;
use App\Models\BoardingHouse;

class LandOwnerRoomController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
        //$this->middleware('landowner');
    }

    public function index($id){

        $bhouse = BoardingHouse::where('bhouse_id', $id)->first();

        return view('landowner.room.boarding-house-room')
            ->with('bhouse', $bhouse);
    }

    public function getRooms(Request $req, $bhouse_id){
        //get the rooms by user

        $sort = explode('.', $req->sort_by);

        $userid = Auth::user()->user_id;
        
        $data = Room::with(['boardingHouse', 'bedspaces'])
            ->where('bhouse_id', $bhouse_id)
            ->whereHas('boardingHouse', function($q) use ($userid){
                $q->where('user_id', $userid);
            })
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }



    public function getBhouseRoomEdit($id){
        return Room::find($id);
    }

    public function store(Request $req, $id){

        $req->validate([
            'room_no' => ['required', 'max: 100'],
            'room_desc' => ['required'],
            'room_img_path' => ['required', 'mimes:jpg,png,bmp'],
            'room_type' => ['required'],
        ], $message = [
            'room_img_path.mimes' => 'Type of the file must be jpg, png or bmp.'
        ]);

        $room_img_path = null;
        //upload image b house
        $roomImgPath = $req->file('room_img_path');
        if($roomImgPath){
            $pathFile = $roomImgPath->store('public/rooms'); //get path of the file
            $room_img_path = explode('/', $pathFile); //split into array using /
        }

        Room::create([
            'bhouse_id' => $id,
            'room_no' => strtoupper($req->room_no),
            'room_desc' => strtoupper($req->room_desc),
            'room_img_path' => $room_img_path[2] != null ? $room_img_path[2]: '',
            'room_type' => strtoupper($req->room_type)
        ]);

        return response()->json([
            'status' => 'saved'
        ]);
    }

    public function update(Request $req, $id){

        $req->validate([
            'room_no' => ['required', 'max: 100'],
            'room_desc' => ['required'],
        ]);

        $data = Room::find($id);

        $room_img_path = null;
        //upload image b house

        $roomImgPath = $req->file('room_img_path');

        if($roomImgPath){
            //check the file and delete to update
            if(Storage::exists('public/rooms/' .$data->room_img_path)) {
                Storage::delete('public/rooms/' . $data->room_img_path);
            }
            $pathFile = $roomImgPath->store('public/rooms'); //get path of the file
            $room_img_path = explode('/', $pathFile); //split into array using /
        }

        $data->room_no = strtoupper($req->room_no);
        $data->room_desc = strtoupper($req->room_desc);
        $data->room_type = strtoupper($req->room_type);
        if($roomImgPath){
            $data->room_img_path = $room_img_path[2];
        }
        $data->save();


        return response()->json([
            'status' => 'updated'
        ]);
    }


    public function destroy($id){
        Room::destroy($id);


        return response()->json([
            'status' => 'deleted'
        ]);
    }



}
