@extends('layouts.front')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center gap-3 mb-8 border-b border-[#312f40] pb-4">
        <div class="w-12 h-12 rounded-xl bg-purple-600/20 flex items-center justify-center text-2xl">👑</div>
        <div>
            <h1 class="text-2xl font-bold text-white">Yükleyici Paneli</h1>
            <p class="text-sm text-gray-400">Hoş geldin, <span class="text-purple-400 font-bold">{{ Auth::user()->name }}</span> ({{ Auth::user()->role }})</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/50 text-green-500 font-bold p-4 rounded-xl mb-6">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-8">
        
        <!-- YENİ SERİ EKLE -->
        <div class="bg-[#1D1B22] p-6 rounded-2xl border border-[#312f40] shadow-xl">
            <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2"><span class="text-purple-500">📚</span> Yeni Seri Ekle</h2>
            
            <form action="{{ route('admin.storeSeries') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-400 mb-1">Seri Adı</label>
                    <input type="text" name="title" required class="w-full bg-[#13111A] border border-[#312f40] text-white rounded-lg px-4 py-2.5 outline-none focus:border-purple-500">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-400 mb-1">Açıklama (Özet)</label>
                    <textarea name="description" rows="3" class="w-full bg-[#13111A] border border-[#312f40] text-white rounded-lg px-4 py-2.5 outline-none focus:border-purple-500"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 mb-1">Kapak Fotoğrafı</label>
                    <input type="file" name="cover_image" accept="image/*" required class="w-full bg-[#13111A] border border-[#312f40] text-gray-400 rounded-lg px-4 py-2 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-purple-600 file:text-white hover:file:bg-purple-700 cursor-pointer">
                </div>

                <button type="submit" class="w-full py-3 mt-2 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-xl transition-colors">Seriyi Kaydet</button>
            </form>
        </div>

        <!-- BÖLÜM YÜKLE -->
        <div class="bg-[#1D1B22] p-6 rounded-2xl border border-[#312f40] shadow-xl h-fit">
            <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2"><span class="text-orange-500">🔥</span> Yeni Bölüm Yükle</h2>
            
            <form action="{{ route('admin.storeChapter') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-400 mb-1">Kayıtlı Seri Seç</label>
                    <select name="series_id" required class="w-full bg-[#13111A] border border-[#312f40] text-white rounded-lg px-4 py-2.5 outline-none focus:border-purple-500 cursor-pointer">
                        <option value="" disabled selected>-- Seri Seçin --</option>
                        @foreach($series as $manga)
                            <option value="{{ $manga->id }}">{{ $manga->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 mb-1">Bölüm Numarası (Örn: 15 veya 15.5)</label>
                    <input type="number" step="0.1" name="chapter_number" required class="w-full bg-[#13111A] border border-[#312f40] text-white rounded-lg px-4 py-2.5 outline-none focus:border-purple-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 mb-1">Bölüm Resimleri (Çoklu Seçim)</label>
                    <input type="file" name="images[]" accept="image/*" multiple required class="w-full bg-[#13111A] border border-[#312f40] text-gray-400 rounded-lg px-4 py-2 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-orange-600 file:text-white hover:file:bg-orange-700 cursor-pointer">
                    <p class="text-[10px] text-gray-500 mt-1">* Sayfaları sıralı seçtiğinizden emin olun (01.jpg, 02.jpg...). Toplu seçebilirsiniz.</p>
                </div>

                <button type="submit" class="w-full py-3 mt-2 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl transition-colors">Bölümü Yükle</button>
            </form>
        </div>

    </div>
</div>
@endsection