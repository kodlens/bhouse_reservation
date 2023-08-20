<?php

namespace Database\Seeders;
use App\Models\RentalType;
use Illuminate\Database\Seeder;

class RentalTypeSeeder extends Seeder
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
                'rental_type' => "PRIVATE",
            ],
            [
                'rental_type' => "SHARED ROOM",
            ],
        ];

        RentalType::insertOrIgnore($data);

    }
}
