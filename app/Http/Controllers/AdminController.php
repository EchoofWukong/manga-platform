<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Sadece Admin ve Uploader yetkisi olanlar girebilir
        if ($user->role === 'user') {
            abort(403, 'Bu alana erişim yetkiniz yok.');
        }

        $series = Series::orderBy('title', 'asc')->get();
        return view('admin.dashboard', compact('series'));
    }
    public function updateSeries(Request $request, $id)
    {
        $series = Series::findOrFail($id);
        $series->title = $request->title;
        $series->description = $request->description;

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $series->cover_image = '/storage/' . $path;
        }
        
        $series->save();
        return back()->with('success', 'Seri başarıyla güncellendi!');
    }

    public function deleteSeries($id)
    {
        Series::findOrFail($id)->delete();
        return redirect('/')->with('success', 'Seri tamamen silindi!');
    }

    public function deleteChapter($id)
    {
        Chapter::findOrFail($id)->delete();
        return back()->with('success', 'Bölüm silindi!');
    }

    public function storeSeries(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Kapak resmini public klasörüne kaydet
        $imagePath = $request->file('cover_image')->store('covers', 'public');

        Series::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'cover_image' => '/storage/' . $imagePath,
            'status' => 'devam_ediyor',
            'views' => 0,
        ]);

        return back()->with('success', 'Yeni seri başarıyla oluşturuldu!');
    }

    public function storeChapter(Request $request)
    {
        $request->validate([
            'series_id' => 'required|exists:series,id',
            'chapter_number' => 'required|numeric',
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $imagePaths = [];

        // Seçilen tüm sayfaları sunucuya yükle ve yollarını diziye aktar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('chapters/' . $request->series_id . '/bolum_' . $request->chapter_number, 'public');
                $imagePaths[] = '/storage/' . $path;
            }
        }

        Chapter::create([
            'series_id' => $request->series_id,
            'chapter_number' => $request->chapter_number,
            'images' => $imagePaths,
        ]);

        return back()->with('success', $request->chapter_number . '. Bölüm başarıyla yüklendi!');
    }
}