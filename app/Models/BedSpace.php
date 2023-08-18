<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BedSpace extends Model
{
    use HasFactory;

    protected $table = 'bedspaces';
    protected $primaryKey = 'bedspace_id';

    protected $fillable = ['room_id', 'bhouse_id', 'bedspace_name', 'bedspace_desc', 'price', 'is_book'];

    public function imgs(){
        return $this->hasMany(BedspaceImg::class, 'bedspace_id', 'bedspace_id');
    }

    public function bhouse(){
        return $this->belongsTo(BoardingHouse::class, 'bhouse_id', 'bhouse_id');
    }

    public function room(){
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }

    
    public function bedspaceImages(){
        return $this->belongsTo(BedspaceImg::class, 'bedspace_id', 'bedspace_id');
    }


}
