<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [
                'state_name' => 'Abia',
                'state_code' => '01',
                'region_id' => '4',

            ],

            [
                'state_name' => 'Adamawa',
                'state_code' => '02',
                'region_id' => '2',

            ],

            [
                'state_name' => 'Akwa Ibom',
                'state_code' => '03',
                'region_id' => '5',

            ],

            [
                'state_name' => 'Anambra',
                'state_code' => '04',
                'region_id' => '4',

            ],

            [
                'state_name' => 'Bauchi',
                'state_code' => '05',
                'region_id' => '2',

            ],

            [
                'state_name' => 'Bayelsa',
                'state_code' => '06',
                'region_id' => '5',

            ],

            [
                'state_name' => 'Benue',
                'state_code' => '07',
                'region_id' => '1',

            ],

            [
                'state_name' => 'Borno',
                'state_code' => '08',
                'region_id' => '2',

            ],

            [
                'state_name' => 'Cross River',
                'state_code' => '09',
                'region_id' => '5',

            ],

            [
                'state_name' => 'Delta',
                'state_code' => '010',
                'region_id' => '5',

            ],

            [
                'state_name' => 'Ebonyi',
                'state_code' => '011',
                'region_id' => '4',

            ],

            [
                'state_name' => 'Edo',
                'state_code' => '012',
                'region_id' => '5',

            ],

            [
                'state_name' => 'Ekiti',
                'state_code' => '013',
                'region_id' => '6',

            ],

            [
                'state_name' => 'Enugu',
                'state_code' => '014',
                'region_id' => '4',

            ],

            [
                'state_name' => 'Gombe',
                'state_code' => '015',
                'region_id' => '2',

            ],

            [
                'state_name' => 'Imo',
                'state_code' => '016',
                'region_id' => '4',

            ],

            [
                'state_name' => 'Jigawa',
                'state_code' => '017',
                'region_id' => '3',

            ],

            [
                'state_name' => 'Kaduna',
                'state_code' => '018',
                'region_id' => '3',

            ],

            [
                'state_name' => 'Kano',
                'state_code' => '019',
                'region_id' => '3',

            ],

            [
                'state_name' => 'Katsina',
                'state_code' => '020',
                'region_id' => '3',

            ],

            [
                'state_name' => 'Kebbi',
                'state_code' => '021',
                'region_id' => '3',

            ],

            [
                'state_name' => 'Kogi',
                'state_code' => '022',
                'region_id' => '1',

            ],

            [
                'state_name' => 'Kwara',
                'state_code' => '023',
                'region_id' => '1',

            ],

            [
                'state_name' => 'Lagos',
                'state_code' => '024',
                'region_id' => '6',

            ],

            [
                'state_name' => 'Nasarawa',
                'state_code' => '025',
                'region_id' => '1',

            ],

            [
                'state_name' => 'Niger',
                'state_code' => '026',
                'region_id' => '1',

            ],

            [
                'state_name' => 'Ogun',
                'state_code' => '027',
                'region_id' => '6',

            ],

            [
                'state_name' => 'Ondo',
                'state_code' => '028',
                'region_id' => '6',

            ],

            [
                'state_name' => 'Osun',
                'state_code' => '029',
                'region_id' => '6',

            ],

            [
                'state_name' => 'Oyo',
                'state_code' => '030',
                'region_id' => '6',

            ],

            [
                'state_name' => 'Plateau',
                'state_code' => '031',
                'region_id' => '1',

            ],

            [
                'state_name' => 'Rivers',
                'state_code' => '032',
                'region_id' => '5',

            ],

            [
                'state_name' => 'Sokoto',
                'state_code' => '033',
                'region_id' => '3',

            ],

            [
                'state_name' => 'Taraba',
                'state_code' => '034',
                'region_id' => '2',

            ],

            [
                'state_name' => 'Yobe',
                'state_code' => '035',
                'region_id' => '2',

            ],

            [
                'state_name' => 'Zamfara',
                'state_code' => '036',
                'region_id' => '3',

            ],

            [
                'state_name' => 'FCT',
                'state_code' => '037',
                'region_id' => '1',

            ],

        ];
        foreach ($rows as $row) {
            DB::table('states')->insert($row);
        }
    }
}
