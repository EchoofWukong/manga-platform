

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MangaController; // BU SATIRI KESİNLİKLE EKLE

// Rotalar aşağıda aynen devam edecek...

// Herkese Açık Sayfalar (Public Routes)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/seriler', [HomeController::class, 'seriler'])->name('seriler');
Route::get('/trendler', [HomeController::class, 'trendler'])->name('trendler');

// Manga Detay, Okuma ve Puanlama Rotaları
Route::get('/manga/{slug}', [MangaController::class, 'show'])->name('manga.show');
Route::get('/manga/{slug}/bolum/{chapter_number}', [MangaController::class, 'read'])->name('manga.read');
Route::post('/manga/{id}/rate', [MangaController::class, 'rate'])->name('manga.rate');

// Laravel Breeze Varsayılan Dashboard Yönlendirmesi (Hata vermemesi için anasayfaya atar)
Route::get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');

// Admin & Uploader Paneli Rotaları (Sadece yetkililer için)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Panel Ana Sayfası
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Ekleme İşlemleri
    Route::post('/seri-ekle', [AdminController::class, 'storeSeries'])->name('storeSeries');
    Route::post('/bolum-ekle', [AdminController::class, 'storeChapter'])->name('storeChapter');
    
    // Düzenleme ve Silme İşlemleri
    Route::put('/series/{id}', [AdminController::class, 'updateSeries'])->name('updateSeries');
    Route::delete('/series/{id}', [AdminController::class, 'deleteSeries'])->name('deleteSeries');
    Route::delete('/chapter/{id}', [AdminController::class, 'deleteChapter'])->name('deleteChapter');
});

// Laravel Breeze Auth (Giriş/Kayıt/Çıkış) Rotaları
require __DIR__.'/auth.php';