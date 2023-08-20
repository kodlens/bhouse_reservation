<?php

namespace Database\Seeders;

use App\Models\Rental;
use Illuminate\Database\Seeder;

class RentalSeeder extends Seeder
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
                'rental_name' => 'rental 101',
                'rental_desc' => 'rental HAS 4 BEDSPACES W/ AIRCON AND 2 CR. FREE WIFI INSTALLED.',
                'rental_img_path' => 'rental1.jpg',
                'rental_type' => 'PRIVATE',
            ],

            [
                'bhouse_id' => 2,
                'rental_name' => 'rental 102',
                'rental_desc' => 'rental HAS 4 BEDSPACES W/ AIRCON AND 2 CR. FREE WIFI INSTALLED.',
                'rental_img_path' => 'rental2.jpg',
                'rental_type' => 'SHARED',
            ],

            [
                'bhouse_id' => 3,
                'rental_name' => 'rental 01',
                'rental_desc' => 'SMALL AND SHARE rental BEDSPACE.',
                'rental_img_path' => 'rental3.jpg',
                'rental_type' => 'PRIVATE',
            ],



        ];

        Rental::insertOrIgnore($data);

    }
}
