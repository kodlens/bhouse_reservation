<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $table = 'rentals';
    protected $primaryKey = 'rental_id';

    protected $fillable = ['bhouse_id', 'rental_name',
        'rental_desc', 'rental_img_path', 'rental_type',
        'is_reserved', 'is_occupied'
    ];


    public function boardingHouse(){
        return $this->belongsTo(BoardingHouse::class, 'bhouse_id', 'bhouse_id');
    }

    public function rental_imgs(){
        return $this->hasMany(RentalImg::class, 'rental_id', 'rental_id');
    }

    public function province(){
        return $this->hasOne(Province::class, 'province', 'provCode');
    }
    public function city(){
        return $this->hasOne(RentalImg::class, 'rental_id', 'rental_id');
    }
    public function barangay(){
        return $this->hasOne(RentalImg::class, 'rental_id', 'rental_id');
    }

}
