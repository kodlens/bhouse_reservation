<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BhouseAmenity extends Model
{
    use HasFactory;


    protected $table = 'bhouse_amenities';
    protected $primaryKey = 'bhouse_amenity_id';

    protected $fillable = ['bhouse_id', 'amenity_id'];


    public function bhouse(){
        return $this->belongsTo(BoardingHouse::class, 'bhouse_id', 'bhouse_id');
    }

    public function amenity(){
        return $this->belongsTo(Amenity::class, 'amenity_id', 'amenity_id');
    }


}
