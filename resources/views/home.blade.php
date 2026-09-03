@extends('layouts.front')

@section('content')
<!-- Orijinal Hero Slider -->
<div class="bg-[#13111A] relative">
    <section class="relative overflow-hidden min-h-[311px]">
        <img src="{{ $series->first()->cover_image ?? '' }}" class="absolute inset-0 w-full h-full object-cover object-top opacity-30 blur-xl">
        <div class="absolute inset-0 backdrop-blur-md bg-black/40"></div>
        <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-[#13111A] to-transparent z-10"></div>

        <div class="relative z-20 py-4 overflow-x-auto scrollbar-hide px-4 flex items-center h-full max-w-[1280px] mx-auto">
            <div class="flex items-end h-[279px]">
                @foreach($series as $manga)
                <div class="mr-3 flex-shrink-0 cursor-pointer transition-all duration-300">
                    <a href="{{ route('manga.show', $manga->slug) }}" class="block relative overflow-hidden rounded-xl border border-[#312f40] {{ $loop->first ? 'w-[195px] h-[279px] border-[#913FE2]' : 'w-[155px] h-[222px] opacity-70 hover:opacity-100' }}">
                        <img src="{{ $manga->cover_image }}" class="object-cover w-full h-full hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/90 to-transparent pt-12 pb-2.5 px-2">
                            <h3 class="text-sm font-bold text-white line-clamp-2">{{ $manga->title }}</h3>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

<!-- Alt Kısım -->
<div class="mx-auto mt-3 mb-6 w-full max-w-[1285px] px-4">
    <div class="flex flex-col lg:flex-row gap-5">
        
        <!-- Sol Taraf -->
        <div class="w-full lg:flex-1 min-w-0">
            <!-- Bugün Popüler Grid -->
            <div class="text-white bg-[#1D1B22] rounded-xl border border-[#312f40]">
                <div class="flex items-center border-b border-[#312f40] px-4 py-3 rounded-t-xl">
                    <h3 class="text-[15px] text-[#DDDDDD] font-bold">Bugün Popüler</h3>
                </div>
                <div class="p-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach($series as $manga)
                    <div class="flex flex-col gap-2 group">
                        <a href="{{ route('manga.show', $manga->slug) }}" class="relative aspect-[3/4] overflow-hidden rounded-xl">
                            <img src="{{ $manga->cover_image }}" class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute top-1.5 left-1.5 bg-black/80 px-1.5 py-0.5 rounded text-[10px] font-bold text-yellow-400">@php $avg = $manga->rating_count > 0 ? round($manga->rating_sum / $manga->rating_count, 1) : 0; @endphp
★ {{ $avg > 0 ? $avg : '0' }}</div>
                        </a>
                        <div>
                            <h4 class="text-[13px] font-bold text-white line-clamp-1 group-hover:text-[#913FE2]">{{ $manga->title }}</h4>
                            @php $latestChapter = $manga->chapters->sortByDesc('chapter_number')->first(); @endphp
                            <p class="text-[12px] text-[#999] mt-0.5">Bölüm {{ $latestChapter ? $latestChapter->chapter_number : 'Yok' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Son Yüklenen Bölümler -->
            <div class="mt-6 text-white mb-3">
                <div class="flex items-center justify-between bg-[#1D1B22] border-b border-[#312f40] px-4 py-2.5 rounded-t-xl">
                    <h3 class="text-[15px] text-[#DDDDDD] font-bold">Son Yüklenen Bölümler</h3>
                    <a href="/seriler" class="px-3 py-1.5 bg-[#6F2598] hover:bg-[#5a1e7b] text-[11px] font-bold rounded-lg transition-colors flex items-center gap-1">Tümünü Gör →</a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 bg-[#1D1B22] rounded-b-xl overflow-hidden border-x border-b border-[#312f40]">
                    @foreach($series as $manga)
                    <div class="flex gap-4 p-4 border-b border-[#312f40] sm:odd:border-r hover:bg-white/[0.02]">
                        <a href="{{ route('manga.show', $manga->slug) }}" class="w-[90px] h-[125px] shrink-0 rounded-lg overflow-hidden border border-[#312f40] group">
                            <img src="{{ $manga->cover_image }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </a>
                        <div class="flex flex-col flex-1 min-w-0 justify-between py-1">
                            <h4 class="text-[14px] font-bold text-white truncate hover:text-[#913FE2]"><a href="{{ route('manga.show', $manga->slug) }}">{{ $manga->title }}</a></h4>
                            <div class="flex flex-col gap-1.5 mt-2">
                                <div class="flex items-center justify-between text-[13px]">
                                    @php $latestChapter = $manga->chapters->sortByDesc('chapter_number')->first(); @endphp
                                    @if($latestChapter)
                                        <a href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $latestChapter->chapter_number]) }}" class="flex items-center gap-2 text-gray-400 hover:text-[#913FE2]"><span class="w-1.5 h-1.5 rounded-full bg-[#913FE2]"></span><span class="font-bold">Bölüm {{ $latestChapter->chapter_number }}</span></a>
                                        <span class="text-[11px] text-gray-500">{{ $latestChapter->created_at->diffForHumans() }}</span>
                                    @else
                                        <span class="text-gray-400">Henüz bölüm yok</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="bg-[#13111A] border border-[#312f40] px-2 py-1 rounded text-[10px] font-bold text-[#a0e040]">
                                    • {{ $manga->status == 'devam_ediyor' ? 'Devam Ediyor' : 'Tamamlandı' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sağ Taraf: Sıralama -->
        <div class="w-full lg:w-[320px] shrink-0">
            <div class="bg-[#1D1B22] p-4 rounded-xl border border-[#312f40]">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-[15px] font-bold text-white">Popüler Seriler</h2>
                    <div class="flex items-center border border-[#312f40] rounded-lg p-0.5 bg-[#13111A]">
                        <button class="px-3 py-1 text-xs rounded-md font-medium bg-[#6F2598] text-white">Haftalık</button>
                        <button class="px-3 py-1 text-xs rounded-md font-medium text-white/60 hover:text-white">Aylık</button>
                    </div>
                </div>
                
                <div class="flex flex-col gap-4">
                    @foreach($series->take(5) as $index => $manga)
                    <a href="{{ route('manga.show', $manga->slug) }}" class="flex gap-4 items-center group">
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg font-black shadow text-sm shrink-0 {{ $index == 0 ? 'bg-gradient-to-br from-amber-400 to-orange-500 text-white' : ($index == 1 ? 'bg-gradient-to-br from-gray-300 to-gray-500 text-black' : ($index == 2 ? 'bg-gradient-to-br from-orange-700 to-amber-900 text-white' : 'bg-[#312f40] text-gray-400')) }}">
                            {{ $index + 1 }}
                        </div>
                        <div class="w-12 h-16 rounded-md overflow-hidden shrink-0">
                            <img src="{{ $manga->cover_image }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col justify-center min-w-0">
                            <h4 class="text-[14px] font-bold text-white truncate group-hover:text-[#913FE2]">{{ $manga->title }}</h4>
                            <p class="text-[12px] font-bold text-yellow-400 mt-1">@php $avg = $manga->rating_count > 0 ? round($manga->rating_sum / $manga->rating_count, 1) : 0; @endphp
★ {{ $avg > 0 ? $avg : '0' }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
@endsection