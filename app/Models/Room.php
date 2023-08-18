<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\BedSpace;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';
    protected $primaryKey = 'room_id';

    protected $fillable = ['bhouse_id', 'room_no',
        'room_desc', 'room_img_path', 'room_type'
    ];


    public function boardingHouse(){
        return $this->belongsTo(BoardingHouse::class, 'bhouse_id', 'bhouse_id');
    }

    public function bedspaces(){
        return $this->hasMany(BedSpace::class, 'room_id', 'room_id');
    }

}
