<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalType extends Model
{
    use HasFactory;


    protected $table = 'rental_types';
    protected $primaryKey = 'rental_type_id';

    protected $fillable = ['rental_type'];


}
