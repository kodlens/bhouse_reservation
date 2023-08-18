<?php

namespace Database\Seeders;


use App\Models\Amenity;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            AminitySeeder::class,
            RuleSeeder::class,
            BoardingHouseSeeder::class,
            RoomSeeder::class,
            BedSpaceSeeder::class,
            BedspaceImgSeeder::class,
            BhouseAmenitySeeder::class,
            RoomTypeSeeder::class
        ]);
    }
}
