<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AminitySeeder extends Seeder
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
                'amenity' => 'WIFI',
            ],
            [
                'amenity' => 'WASHER',
            ],
            [
                'amenity' => 'KITCHEN',
            ],
            [
                'amenity' => 'DRYER',
            ],
            [
                'amenity' => 'AIR CONDITIONING',
            ],
            [
                'amenity' => 'HEATING',
            ],
            [
                'amenity' => 'TV',
            ],
            [
                'amenity' => 'DEDICATED WORKSPACE',
            ],
            [
                'amenity' => 'HAIR DRYER',
            ],
            [
                'amenity' => 'IRON',
            ],

            [
                'amenity' => 'POOL',
            ],
            [
                'amenity' => 'HOT TUB',
            ],
            [
                'amenity' => 'FREE PARKING PREMISES',
            ],
            [
                'amenity' => 'BBQ GRILL',
            ],
            [
                'amenity' => 'GYM',
            ],
            [
                'amenity' => 'INDOOR FIREPLACE',
            ],
            [
                'amenity' => 'SMOKING ALLOWED',
            ],
            [
                'amenity' => 'SMOKE ALARM',
            ],
            [
                'amenity' => 'CARBON MONOXIDE ALARM',
            ],
            [
                'amenity' => 'CRIB',
            ],
            [
                'amenity' => 'PARKING AREA',
            ],

        ];

        Amenity::insertOrIgnore($data);

    }
}
