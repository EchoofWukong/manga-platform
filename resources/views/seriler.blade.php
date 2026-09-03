@extends('layouts.front')

@section('content')
<div class="max-w-[1280px] mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-white border-b border-[#312f40] pb-2">Tüm Seriler</h1>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($series as $manga)
        <div class="flex flex-col gap-2 group">
            <a href="#" class="relative aspect-[3/4] overflow-hidden rounded-xl border border-[#312f40] hover:border-[#913FE2]/50 transition-colors">
                <img src="{{ $manga->cover_image }}" class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105">
                <div class="absolute top-1.5 left-1.5 bg-black/80 px-1.5 py-0.5 rounded text-[10px] font-bold text-yellow-400">seriler.blade.php</div>
            </a>
            <div>
                <h4 class="text-[13px] font-bold text-white line-clamp-1 group-hover:text-[#913FE2] transition-colors">{{ $manga->title }}</h4>
                <!-- Hata çıkaran yer düzeltildi (?-> eklendi) -->
                <p class="text-[11px] text-gray-400 mt-0.5">Bölüm {{ $manga->chapters->first()?->chapter_number ?? 'Yok' }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection