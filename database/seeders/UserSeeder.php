<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
            // [
            //     'username' => 'angel',
            //     'lname' => 'LOPEZ',
            //     'fname' => 'ANGEL',
            //     'mname' => 'P',
            //     'suffix' => '',
            //     'sex' => 'FEMALE',
            //     'province' => 'MISMAIS OCCIDENTAL',
            //     'city' => 'TANGUB CITY',
            //     'barangay' => 'CANIANGAN',
            //     'street' => 'P-6',
            //     'email' => 'angel@dev.com',
            //     'contact_no' => '09167789581',
            //     'business_permit_img' => '',
            //     'role' => 'BOARDER',
            //     'active' => 1,
            //     'password' => Hash::make('a')
            // ],
            [
                'username' => 'bh1',
                'lname' => 'SMITH',
                'fname' => 'JOHN',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'province' => 'MISMAIS OCCIDENTAL',
                'city' => 'OZAMIS CITY',
                'barangay' => 'SINUSZA',
                'street' => 'P-SAMPLE',
                'email' => 'bh1@dev.com',
                'contact_no' => '09167789582',
                'business_permit_img' => 'X58cNXkY5OWADcJVy3wO1jCAKKGAqC9NkoQ5yr5x.png',
                'role' => 'LANDOWNER',
                'active' => 1,
                'password' => Hash::make('a')
            ],
            [
                'username' => 'bh2',
                'lname' => 'DOE',
                'fname' => 'JOHN',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'province' => 'MISMAIS OCCIDENTAL',
                'city' => 'OZAMIS CITY',
                'barangay' => 'SINUSZA',
                'street' => 'P-SAMPLE',
                'email' => 'bh2@dev.com',
                'contact_no' => '09051234598',
                'business_permit_img' => '',
                'active' => 1,
                'role' => 'LANDOWNER',
                'password' => Hash::make('a')
            ],
            [
                'username' => 'bh3',
                'lname' => 'CHAN',
                'fname' => 'PETER',
                'mname' => '',
                'sex' => 'FEMALE',
                'suffix' => '',
                'province' => 'MISMAIS OCCIDENTAL',
                'city' => 'OZAMIS CITY',
                'barangay' => 'SINUSZA',
                'street' => 'P-SAMPLE',
                'email' => 'bh3@dev.com',
                'contact_no' => '09051234598',
                'business_permit_img' => '',
                'active' => 1,
                'role' => 'LANDOWNER',
                'password' => Hash::make('a')
            ],
            [
                'username' => 'admin',
                'lname' => 'CABARDO',
                'fname' => 'MAUREEN',
                'mname' => '',
                'suffix' => '',
                'sex' => 'FEMALE',
                'province' => 'MISMAIS OCCIDENTAL',
                'city' => 'OZAMIS CITY',
                'barangay' => 'SINUSZA',
                'street' => 'P-SAMPLE',
                'email' => 'admin@dev.com',
                'contact_no' => '09167789584',
                'business_permit_img' => '',
                'active' => 1,
                'role' => 'ADMINISTRATOR',
                'password' => Hash::make('a')
            ],


            [
                'username' => 'carlos',
                'lname' => 'POYOT',
                'fname' => 'CARLOS',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'province' => '1042',
                'city' => '104215',
                'barangay' => '104215025',
                'street' => 'JUAN LUNA ST.',
                'email' => 'carlos@sample.com',
                'contact_no' => '09167789584',
                'business_permit_img' => '',
                'active' => 1,
                'role' => 'LANDOWNER',
                'password' => Hash::make('a')
            ],

            [
                'username' => 'cenas',
                'lname' => 'CENAS',
                'fname' => 'VIVIAN',
                'mname' => '',
                'suffix' => '',
                'sex' => 'FEMALE',
                'province' => '1042',
                'city' => '104215',
                'barangay' => '104215025',
                'street' => 'JUAN LUNA ST.',
                'email' => 'vivian@sample.com',
                'contact_no' => '09167789584',
                'business_permit_img' => '',
                'active' => 1,
                'role' => 'LANDOWNER',
                'password' => Hash::make('a')
            ],
            
            // [
            //     'username' => 'kimchie',
            //     'lname' => 'HIBAYA',
            //     'fname' => 'NIMCHIE',
            //     'mname' => '',
            //     'suffix' => '',
            //     'sex' => 'FEMALE',
            //     'province' => 'MISMAIS OCCIDENTAL',
            //     'city' => 'OZAMIS CITY',
            //     'barangay' => 'SINUSZA',
            //     'street' => 'P-SAMPLE',
            //     'email' => 'kimchie@dev.com',
            //     'contact_no' => '09267789584',
            //     'active' => 1,
            //     'business_permit_img' => '',
            //     'role' => 'BOARDER',
            //     'password' => Hash::make('a')
            // ]
        ];

        \App\Models\User::insertOrIgnore($data);
    }
}
