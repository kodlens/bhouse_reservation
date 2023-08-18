<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rule;

class RuleSeeder extends Seeder
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
                'rule' => 'NO BEVERAGE/CIGARRETE',
            ],
            [
                'rule' => 'NO OUTSIDERS ALLOWED',
            ],
            [
                'rule' => 'NO PETS ALLOWED',
            ],

        ];

        Rule::insertOrIgnore($data);
    }
}
