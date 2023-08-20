<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalImg extends Model
{
    use HasFactory;

    protected $table = 'rental_imgs';
    protected $primaryKey = 'rental_img_id';

    protected $fillable = ['rental_id','rental_img_path'];

    public function rental(){
        return $this->belongsTo(Rental::class, 'rental_id', 'rental_id');
    }

}
