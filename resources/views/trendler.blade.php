@extends('layouts.front')

@section('content')
<div class="max-w-6xl mx-auto px-3 py-6 sm:px-4 sm:py-10">
    <!-- Başlık Alanı -->
    <div class="mb-7">
        <div class="flex items-center gap-3 mb-1">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-orange-500/10">
                <span class="text-orange-400 text-lg">📈</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white">Trend Seriler</h1>
        </div>
        <p class="text-white/35 text-sm pl-12 flex items-center gap-1.5">
            <span>Son 7 günün ağırlıklı sıralaması</span>
        </p>
    </div>

    <!-- Filtre Butonları -->
    <div class="bg-[#13111A] border border-white/[0.07] rounded-2xl p-3 sm:p-4 mb-6">
        <div class="flex gap-1.5 overflow-x-auto scrollbar-hide">
            <button class="flex items-center gap-1.5 px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl text-[11px] sm:text-xs font-semibold whitespace-nowrap transition-all duration-200 shrink-0 bg-white/[0.04] text-white/45 hover:bg-white/[0.08] hover:text-white/80">Bugün</button>
            <button class="flex items-center gap-1.5 px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl text-[11px] sm:text-xs font-semibold whitespace-nowrap transition-all duration-200 shrink-0 bg-[#913FE2] text-white shadow-[0_0_18px_rgba(145,63,226,0.35)]">Bu Hafta</button>
            <button class="flex items-center gap-1.5 px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl text-[11px] sm:text-xs font-semibold whitespace-nowrap transition-all duration-200 shrink-0 bg-white/[0.04] text-white/45 hover:bg-white/[0.08] hover:text-white/80">Bu Ay</button>
            <button class="flex items-center gap-1.5 px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl text-[11px] sm:text-xs font-semibold whitespace-nowrap transition-all duration-200 shrink-0 bg-white/[0.04] text-white/45 hover:bg-white/[0.08] hover:text-white/80">Tüm Zaman</button>
        </div>
    </div>

    <!-- Trend Listesi -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($series as $index => $manga)
        <a href="#" class="relative aspect-[3/4] overflow-hidden rounded-xl group border border-[#312f40] hover:border-[#913FE2]/50 transition-colors">
            <!-- Derece Rozeti -->
            <div class="absolute top-2 left-2 z-10 w-7 h-7 flex items-center justify-center rounded-md font-black text-sm shadow-md {{ $index == 0 ? 'bg-gradient-to-br from-amber-400 to-orange-500 text-white' : ($index == 1 ? 'bg-gradient-to-br from-gray-300 to-gray-500 text-black' : ($index == 2 ? 'bg-gradient-to-br from-orange-700 to-amber-900 text-white' : 'bg-[#1D1B22] text-gray-400 border border-[#312f40]')) }}">
                {{ $index + 1 }}
            </div>
            
            <img src="{{ $manga->cover_image }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
            
            <div class="absolute bottom-3 left-3 right-3">
                <h4 class="text-[13px] font-bold text-white line-clamp-2 group-hover:text-[#913FE2] transition-colors">{{ $manga->title }}</h4>
                <div class="flex items-center gap-1 mt-1 text-[11px] text-gray-400">
                    <span class="text-yellow-400 font-bold">seriler.blade.php</span>
                    <span>• 👁️ {{ number_format($manga->views) }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection