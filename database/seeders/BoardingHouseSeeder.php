<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\BoardingHouse;

class BoardingHouseSeeder extends Seeder
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
                'bhouse_name' => 'CENAS BOARDING HOUSE',
                'bhouse_desc' => 'Bedspace located at corner Juan luna St, side at Gov. Alfonso D. Tan College',
                'user_id' => 6,
                'contact_person' => '',
                'contact_no' => '',
                'bhouse_rule' => '',
                'amenities' => '',
                'bhouse_img_path' => 'bhouse01.jpg',
                'province' => '1042',
                'city' => '104215',
                'barangay' => '104215025',
                'street' => 'JUAN LUNA ST p-BOUGAINVILLA',
                'lat' => '8.064388825691795',
                'long' => '123.75495928210073',
                'is_approve' => 0
            ],
            [
                'bhouse_name' => 'BOARDING2 HOUSE',
                'bhouse_desc' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae quasi eligendi deserunt, magni sequi asperiores.',
                'user_id' => 1,
                'contact_person' => '',
                'contact_no' => '',
                'bhouse_rule' => 'SAMPLE BHOUSE RULE',
                'amenities' => 'SWIMMING POOL',
                'bhouse_img_path' => 'bhouse02.jpg',
                'province' => '1042',
                'city' => '104215',
                'barangay' => '104215025',
                'street' => 'JUAN LUNA ST p-BOUGAINVILLA',
                'lat' => '8.063680587142077',
                'long' => '123.75273048877715',
                'is_approve' => 0
            ],
            [
                'bhouse_name' => 'BOARDING3 HOUSE',
                'bhouse_desc' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae quasi eligendi deserunt, magni sequi asperiores.',
                'user_id' => 4,
                'contact_person' => '',
                'contact_no' => '',
                'bhouse_rule' => 'SAMPLE BHOUSE RULE',
                'amenities' => 'SWIMMING POOL',
                'bhouse_img_path' => 'bhouse03.jpg',
                'province' => '1042',
                'city' => '104215',
                'barangay' => '104215025',
                'street' => 'JUAN LUNA ST p-BOUGAINVILLA',
                'lat' => '8.061486981739758',
                'long' => '123.75372290611267',
                'is_approve' => 0
            ],
            [
                'bhouse_name' => 'BOARDING4 HOUSE',
                'bhouse_desc' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae quasi eligendi deserunt, magni sequi asperiores.',
                'user_id' => 5,
                'contact_person' => '',
                'contact_no' => '',
                'bhouse_rule' => 'SAMPLE BHOUSE RULE',
                'amenities' => 'SWIMMING POOL',
                'bhouse_img_path' => 'bhouse04.jpg',
                'province' => '1042',
                'city' => '104215',
                'barangay' => '104215025',
                'street' => 'JUAN LUNA ST p-BOUGAINVILLA',
                'lat' => '8.063834617098614',
                'long' => '123.75342249870299',
                'is_approve' => 0
            ],
            [
                'bhouse_name' => 'POYOT BOARDING HOUSE',
                'bhouse_desc' => 'Boarding with 24/7 CCTV. Located near the gate 2 of the school.',
                'user_id' => 5,
                'contact_person' => '',
                'contact_no' => '',
                'bhouse_rule' => '',
                'amenities' => '',
                'bhouse_img_path' => 'bh04.jpg',
                'province' => '1042',
                'city' => '104215',
                'barangay' => '104215025',
                'street' => 'JUAN LUNA ST p-BOUGAINVILLA',
                'lat' => '8.06631693122091',
                'long' => '123.75695796599443',
                'is_approve' => 0
            ],

        ];

        BoardingHouse::insertOrIgnore($data);

    }
}
