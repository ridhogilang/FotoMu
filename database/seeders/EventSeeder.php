<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            "event" => "Dieng Janabdra",
            "foto_cover" => "foto_covers/67433729da588.jpg",
            "lokasi" => "-7.7916167880215195, 110.36704796292844",
            "tanggal" => Carbon::now()
        ]);

        Event::create([
            "event" => "Malioboro Running",
            "foto_cover" => "foto_covers/67433729da588.jpg",
            "lokasi" => "-7.7916167880215195, 110.36704796292844",
            "tanggal" => Carbon::now()
        ]);

        Event::create([
            "event" => "Nikahan Angga",
            "foto_cover" => "foto_covers/67433729da588.jpg",
            "lokasi" => "-7.7916167880215195, 110.36704796292844",
            "tanggal" => Carbon::now()
        ]);

        Event::create([
            "event" => "Wisuda Janabadra",
            "foto_cover" => "foto_covers/67433729da588.jpg",
            "lokasi" => "-7.7916167880215195, 110.36704796292844",
            "tanggal" => Carbon::now()
        ]);

        Event::create([
            "event" => "Fadkhera Futsal",
            "foto_cover" => "foto_covers/67433729da588.jpg",
            "lokasi" => "-7.7916167880215195, 110.36704796292844",
            "tanggal" => Carbon::now()
        ]);
    }
}
