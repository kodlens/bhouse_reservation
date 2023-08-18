<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
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
                'room_no' => 'ROOM 101',
                'room_desc' => 'ROOM HAS 4 BEDSPACES W/ AIRCON AND 2 CR. FREE WIFI INSTALLED.',
                'room_img_path' => 'room1.jpg',
                'room_type' => 'PRIVATE',
            ],

            [
                'bhouse_id' => 2,
                'room_no' => 'ROOM 102',
                'room_desc' => 'ROOM HAS 4 BEDSPACES W/ AIRCON AND 2 CR. FREE WIFI INSTALLED.',
                'room_img_path' => 'room2.jpg',
                'room_type' => 'SHARED ROOM',
            ],

            [
                'bhouse_id' => 3,
                'room_no' => 'ROOM 01',
                'room_desc' => 'SMALL AND SHARE ROOM BEDSPACE.',
                'room_img_path' => 'tlX0liWQ7mXnxIaMRBfypHde7HQwBZYEDmZi6MUF.jpg',
                'room_type' => 'SHARED ROOM',
            ],



        ];

        Room::insertOrIgnore($data);

    }
}
