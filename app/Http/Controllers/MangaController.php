<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Chapter;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    // Manga Detay Sayfası (Kapak, Özet ve Bölüm Listesi)
    public function show(string $slug)
    {
        // Mangayı ve bölümlerini (en yeniden eskiye sıralı) getir
        $manga = Series::with(['chapters' => function($q) {
            $q->orderBy('chapter_number', 'desc');
        }])->where('slug', $slug)->firstOrFail();

        return view('manga', compact('manga'));
    }

    // Manga Okuma Ekranı (Daha önce yaptığımız)
    public function read(string $slug, string $chapter_number)
    {
        $manga = Series::where('slug', $slug)->firstOrFail();
        $chapter = $manga->chapters()->where('chapter_number', $chapter_number)->firstOrFail();
        
        // Admin panelinden yüklenen JSON resimlerini alıyoruz (Eğer yoksa placeholder göster)
        $images = $chapter->images ?? [
            'https://via.placeholder.com/720x1000/1a1a1a/ffffff?text=Resim+Bulunamadi'
        ];

        return view('okuma', compact('manga', 'chapter', 'images'));
    }
    public function rate(Request $request, string $id)
    {
        $request->validate(['score' => 'required|integer|min:1|max:5']);
        $series = Series::findOrFail($id);
        
        $ip = $request->ip();
        
        // Bu IP daha önce oy vermiş mi kontrol et
        $existingRating = \DB::table('ratings')
            ->where('series_id', $series->id)
            ->where('ip_address', $ip)
            ->first();

        if ($existingRating) {
            // Eski oyu çıkar, yeni oyu ekle
            $series->rating_sum = $series->rating_sum - $existingRating->score + $request->score;
            
            \DB::table('ratings')
                ->where('id', $existingRating->id)
                ->update(['score' => $request->score, 'updated_at' => now()]);
        } else {
            // İlk kez oy veriyor
            $series->rating_sum += $request->score;
            $series->rating_count += 1;
            
            \DB::table('ratings')->insert([
                'series_id' => $series->id,
                'ip_address' => $ip,
                'score' => $request->score,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $series->save();

        $newAverage = round($series->rating_sum / $series->rating_count, 1);
        return response()->json(['success' => true, 'new_rating' => $newAverage, 'count' => $series->rating_count]);
    }
    
}