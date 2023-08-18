<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
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
                'room_type' => "PRIVATE",
            ],
            [
                'room_type' => "SHARED ROOM",
            ],
        ];

        RoomType::insertOrIgnore($data);

    }
}
