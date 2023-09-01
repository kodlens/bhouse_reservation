<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $primaryKey = 'reservation_id';

    protected $fillable = [
        'reservation_ref',
        'user_id',
        'rental_id',
        'price',
        'book_datetime',
        'status',
        'approved_datetime',
    ];


    public function rental(){
        return $this->belongsTo(Rental::class, 'rental_id', 'rental_id');
    }

    

}
