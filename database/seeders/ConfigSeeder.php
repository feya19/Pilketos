<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TYPE[
        //     0 = TEXT,
        //     1 = TEXTAREA,
        //     2 = FILE,
        //     3 = SELECT, 
        //     4 = Date,
        //     5 = Time,
        // ] 

        Config::create([
            'name'  => 'app_name',
            'label' => 'Application Name',
            'value' => 'Pilketos',
            'type'  => 0
        ]);

        Config::create([
            'name'  => 'app_logo',
            'label' => 'Logo',
            'type'  => 2
        ]);

        Config::create([
            'name'  => 'vote_date_start',
            'label' => 'Tanggal Pemilihan Mulai',
            'value' => '',
            'type'  => 4
        ]);

        Config::create([
            'name'  => 'vote_date_end',
            'label' => 'Tanggal Pemilihan Berakhir',
            'value' => '',
            'type'  => 5
        ]);

        Config::create([
            'name'  => 'vote_open',
            'label' => 'Jam Mulai',
            'value' => '',
            'type'  => 6
        ]);

        Config::create([
            'name'  => 'vote_closed',
            'label' => 'Jam Selesai',
            'value' => '',
            'type'  => 7
        ]);

    }
}
