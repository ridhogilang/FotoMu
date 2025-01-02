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
            "event" => "Sentolo to Dieng",
            "foto_cover" => "foto_covers/dieng.jpg",
            "lokasi" => "-7.784684995919323,110.35972595214845",
            "deskripsi" => "PKKM Sentolo ke Dieng",
            "tanggal" => Carbon::now()
        ]);

        Event::create([
            "event" => "Sentolo to Dieng (Terang)",
            "foto_cover" => "foto_covers/diengterang.jpg",
            "lokasi" => "-7.812127995521323,110.3628158569336",
            "deskripsi" => "PKKM Sentolo ke Dieng Terang",
            "tanggal" => Carbon::now()
        ]);

        Event::create([
            "event" => "Sentolo to Dieng (Gelap)",
            "foto_cover" => "foto_covers/dienggelap.jpg",
            "lokasi" => "-7.742838073130229,110.35303115844727",
            "deskripsi" => "PKKM Sentolo ke Dieng Gelap",
            "tanggal" => Carbon::now()
        ]);

        Event::create([
            "event" => "Maliboro Running",
            "foto_cover" => "foto_covers/running.jpg",
            "lokasi" => "-7.792364407252224,110.36590576171876",
            "deskripsi" => "Event tahunan maliboro running",
            "tanggal" => Carbon::now()
        ]);

        Event::create([
            "event" => "Event Nikahan Agus",
            "foto_cover" => "foto_covers/nikahan.jpg",
            "lokasi" => "-7.782653339894105,110.37414550781251",
            "deskripsi" => "Pernikahan dari saudara agus",
            "tanggal" => Carbon::now()
        ]);

        Event::create([
            "event" => "Fadkhera Futsal",
            "foto_cover" => "foto_covers/futsal.jpg",
            "lokasi" => "-7.802519031532856,110.393285751342794",
            "deskripsi" => "Event fadkhera futsal hari sabtu",
            "tanggal" => Carbon::now()
        ]);
    }
}
