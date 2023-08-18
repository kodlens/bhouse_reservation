<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardingHouseRule extends Model
{
    use HasFactory;

    protected $table = 'boarding_house_rules';

    protected $primaryKey = 'boarding_house_rule_id';

    protected $fillable = ['bhouse_id', 'rule_id'];

    public function bhouse(){
        return $this->belongsTo(BoardingHouse::class, 'bhouse_id', 'bhouse_id');
    }



}
