<?php

namespace Database\Seeders;


use App\Models\BhouseAmenity;
use Illuminate\Database\Seeder;

class BhouseAmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = [
            [
                'bhouse_id' => 1,
                'amenity_id' => 1,
            ],
            [
                'bhouse_id' => 1,
                'amenity_id' => 2
            ],
            [
                'bhouse_id' => 1,
                'amenity_id' => 3,
            ],



        ];

        BhouseAmenity::insertOrIgnore($data);


    }
}
