<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JamOperasional;

class JamOperasionalSeeder extends Seeder
{
    public function run(): void
    {
        JamOperasional::firstOrCreate(
            ['day_group' => 'Senin - Jumat'],
            ['open_time' => '08:00', 'close_time' => '22:00']
        );

        JamOperasional::firstOrCreate(
            ['day_group' => 'Sabtu - Minggu'],
            ['open_time' => '09:00', 'close_time' => '23:00']
        );
    }
}
