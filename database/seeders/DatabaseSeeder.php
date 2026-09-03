<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Series;
use App\Models\Genre;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $aksiyon = Genre::create(['name' => 'Aksiyon', 'slug' => 'aksiyon']);
        $murim = Genre::create(['name' => 'Murim', 'slug' => 'murim']);
        $fantezi = Genre::create(['name' => 'Fantastik', 'slug' => 'fantastik']);

        $manga1 = Series::create([
            'title' => 'Nano Machine',
            'slug' => 'nano-machine',
            'description' => 'Gelecekten gelen bir nano makine ile dövüş sanatları ustası olma hikayesi.',
            'cover_image' => 'https://cdn.toontaku.com/series/cmqfr3fcr0001w4qksu3uuq2q/cover-32a983b6.webp',
            'status' => 'devam_ediyor',
            'views' => 15000,
        ]);

        $manga2 = Series::create([
            'title' => 'İkinci Kez Yaşayan Ranker',
            'slug' => 'ikinci-kez-yasayan-ranker',
            'description' => 'Kayıp kardeşinin izini süren bir savaşçının kuledeki intikamı.',
            'cover_image' => 'https://cdn.toontaku.com/series/01a0621f-6ec9-7245-8506-1d534c1540b5/ikinci-kez-yasayan-ranker-cover-be9f8dc7.webp',
            'status' => 'devam_ediyor',
            'views' => 34793,
        ]);

        $manga1->genres()->attach([$aksiyon->id, $murim->id]);
        $manga2->genres()->attach([$aksiyon->id, $fantezi->id]);

        $manga1->chapters()->create(['chapter_number' => 328, 'title' => 'Gelecekten Gelen', 'is_locked' => false]);
        $manga2->chapters()->create(['chapter_number' => 230, 'title' => 'Kuleye Giriş', 'is_locked' => false]);
    }
}