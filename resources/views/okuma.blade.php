@extends('layouts.front')

@section('content')
<div class="bg-[#0e0c15] min-h-screen pb-20">
    
    <!-- Üst Kontrol Barı -->
    <div class="max-w-4xl mx-auto px-4 pt-6 pb-4">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex flex-col text-center md:text-left">
                <h1 class="text-xl font-bold text-white hover:text-[#913FE2] transition-colors">
                    <a href="#">{{ $manga->title }}</a>
                </h1>
                <h2 class="text-sm font-bold text-gray-400 mt-1">Bölüm {{ $chapter->chapter_number }}</h2>
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <button class="px-4 py-2 bg-[#1D1B22] border border-[#312f40] hover:border-[#913FE2] rounded-lg text-sm text-white transition-all flex-1 md:flex-none">
                    < Önceli
                </button>
                
                <select class="px-4 py-2 bg-[#13111A] border border-[#312f40] rounded-lg text-sm text-white font-bold outline-none flex-1 md:flex-none cursor-pointer">
                    <option>Bölüm {{ $chapter->chapter_number }}</option>
                </select>
                
                <button class="px-4 py-2 bg-[#913FE2] hover:bg-[#7a34be] rounded-lg text-sm font-bold text-white transition-all flex-1 md:flex-none">
                    Sonraki >
                </button>
            </div>
        </div>
    </div>

    <!-- Okuma Alanı (Resimler) -->
    <div class="max-w-[720px] mx-auto bg-[#1D1B22] md:rounded-2xl overflow-hidden shadow-2xl border border-white/5 flex flex-col items-center">
        @foreach($images as $index => $img)
        <div class="relative w-full group">
            <img src="{{ $img }}" alt="Sayfa {{ $index + 1 }}" class="w-full h-auto select-none pointer-events-none" loading="lazy">
            <div class="absolute bottom-4 right-4 bg-black/60 backdrop-blur-md px-3 py-1 rounded-full text-xs font-bold text-white/70 opacity-0 group-hover:opacity-100 transition-opacity">
                {{ $index + 1 }} / {{ count($images) }}
            </div>
        </div>
        @endforeach
    </div>

    <!-- Bölüm Sonu Kutusu -->
    <div class="max-w-[720px] mx-auto mt-8 bg-[#1D1B22] border border-[#312f40] rounded-xl p-8 text-center">
        <h3 class="text-xl font-black text-white mb-2 tracking-widest">BÖLÜM SONU</h3>
        <p class="text-sm text-gray-400">Sonraki bölüme geçmek için aşağıdaki kontrolleri kullanabilirsiniz</p>
    </div>

    <!-- Alt Kontrol Barı -->
    <div class="max-w-4xl mx-auto px-4 mt-8 flex items-center justify-between gap-3">
        <select class="px-4 py-2.5 bg-[#13111A] border border-[#312f40] rounded-lg text-sm text-white font-bold outline-none w-48 cursor-pointer hidden md:block">
            <option>Bölüm {{ $chapter->chapter_number }}</option>
        </select>
        
        <div class="flex items-center gap-3 w-full md:w-auto">
            <button class="px-6 py-2.5 bg-[#1D1B22] border border-[#312f40] hover:border-[#913FE2] rounded-lg text-sm text-white font-bold transition-all flex-1 md:flex-none">
                < Önceki
            </button>
            <button class="px-6 py-2.5 bg-[#913FE2] hover:bg-[#7a34be] rounded-lg text-sm font-bold text-white transition-all flex-1 md:flex-none shadow-[0_0_15px_rgba(145,63,226,0.3)]">
                Sonraki >
            </button>
        </div>
    </div>

</div>
@endsection