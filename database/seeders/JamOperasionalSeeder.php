<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JamOperasional;

class JamOperasionalSeeder extends Seeder
{
    public function run(): void
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        foreach ($days as $day) {
            JamOperasional::firstOrCreate(
                ['day' => $day],
                ['open_time' => null, 'close_time' => null]
            );
        }
    }
}
