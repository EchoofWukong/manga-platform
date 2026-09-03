@extends('layouts.front')

@section('content')
<div class="bg-[#13111A] min-h-screen text-white/90 overflow-x-hidden pb-12">
    
    <div class="relative isolate">
        <div class="absolute inset-x-0 top-0 h-[450px] overflow-hidden z-0 pointer-events-none">
            <img src="{{ $manga->cover_image }}" class="w-full h-full object-cover blur-xl scale-110 opacity-30">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#13111A]/80 to-[#13111A]"></div>
        </div>
        
        <div class="mx-auto w-full md:w-[95%] max-w-[1285px] px-4 relative z-10 pt-8">
            
            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/50 text-green-500 p-3 rounded-xl mb-4 font-bold">✓ {{ session('success') }}</div>
            @endif

            <div class="lg:flex lg:gap-9">
                <!-- SOL: Kapak ve İstatistikler -->
                <div class="lg:max-w-[320px] w-full flex flex-col gap-4">
                    <div class="relative aspect-[2/3] rounded-xl overflow-hidden shadow-2xl border border-[#312f40]">
                        <img src="{{ $manga->cover_image }}" alt="{{ $manga->title }}" class="w-full h-full object-cover">
                    </div>
                    
                    <div class="bg-[#1D1B22] rounded-xl p-4 border border-[#312f40]">
                        <div class="flex justify-around text-center items-center">
                            <div>
                                @php 
                                    $avg = $manga->rating_count > 0 ? round($manga->rating_sum / $manga->rating_count, 1) : 0; 
                                @endphp
                                <div class="text-xl font-bold text-yellow-400" id="rating-display">★ {{ $avg > 0 ? $avg : 'Yok' }}</div>
                                <div class="text-[10px] text-white/60 mt-1" id="rating-count-display">{{ $manga->rating_count }} Oy</div>
                            </div>
                            <div class="w-px bg-[#312f40] h-10"></div>
                            <div>
                                <div class="text-xl font-bold text-green-400">{{ $manga->chapters->count() }}</div>
                                <div class="text-xs text-white/60 mt-1">Bölüm</div>
                            </div>
                        </div>
                        
                        <!-- Puan Verme Yıldızları -->
                        <div class="mt-4 pt-4 border-t border-[#312f40] text-center">
                            <p class="text-xs text-gray-400 mb-2">Bu Seriye Puan Ver</p>
                            <div class="flex justify-center gap-1 text-2xl cursor-pointer" id="star-rating">
                                @for($i=1; $i<=5; $i++)
                                    <span class="star text-gray-600 hover:text-yellow-400 transition-colors" data-value="{{ $i }}">★</span>
                                @endfor
                            </div>
                            <p id="rating-msg" class="text-[10px] text-green-400 mt-2 hidden"></p>
                        </div>
                    </div>

                    <!-- ADMİN KONTROLLERİ (Sadece yetkililer görür) -->
                    @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'uploader']))
                    <div class="bg-purple-900/20 border border-purple-500/30 rounded-xl p-4 flex flex-col gap-2">
                        <p class="text-xs text-purple-300 font-bold mb-1">👑 Yetkili İşlemleri</p>
                        <button onclick="document.getElementById('editModal').classList.remove('hidden')" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition-colors">✏️ Seriyi Düzenle</button>
                        
                        <form action="{{ route('admin.deleteSeries', $manga->id) }}" method="POST" onsubmit="return confirm('Bu seriyi ve TÜM bölümlerini silmek istediğinize emin misiniz?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg transition-colors">🗑️ Seriyi Tamamen Sil</button>
                        </form>
                    </div>
                    @endif
                    
                    <div class="grid grid-cols-2 gap-3 mt-1">
                        @if($manga->chapters->isNotEmpty())
                            @php 
                                $firstChap = $manga->chapters->sortBy('chapter_number')->first()->chapter_number; 
                                $lastChap = $manga->chapters->sortByDesc('chapter_number')->first()->chapter_number;
                            @endphp
                            <a href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $firstChap]) }}" class="flex items-center justify-center py-3 bg-[#1D1B22] border border-[#312f40] hover:bg-white/5 rounded-xl text-sm font-bold transition-colors">İlk Bölüm</a>
                            <a href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $lastChap]) }}" class="flex items-center justify-center py-3 bg-[#913FE2] hover:bg-[#7a34be] rounded-xl text-sm font-bold shadow-[0_0_15px_rgba(145,63,226,0.3)] transition-colors">Son Bölüm</a>
                        @endif
                    </div>
                </div>

                <!-- SAĞ: Bilgiler ve Bölüm Listesi -->
                <div class="w-full mt-6 lg:mt-0">
                    <h1 class="text-3xl lg:text-4xl font-black mb-3">{{ $manga->title }}</h1>
                    
                    <div class="flex items-center gap-3 text-xs font-bold mb-4">
                        <span class="bg-[#a0e040]/20 text-[#a0e040] px-2 py-1 rounded">Devam Ediyor</span>
                        <span class="bg-white/10 text-white px-2 py-1 rounded">MANHWA</span>
                    </div>

                    <div class="text-sm text-gray-300 leading-relaxed mb-8 bg-[#1D1B22] p-5 rounded-xl border border-[#312f40]">
                        {{ $manga->description ?? 'Bu seri için henüz bir açıklama girilmedi.' }}
                    </div>

                    <!-- Bölüm Listesi Kutusu -->
                    <div class="bg-[#1D1B22] rounded-xl border border-[#312f40] overflow-hidden">
                        <div class="bg-[#18161d] px-5 py-4 border-b border-[#312f40] flex justify-between items-center">
                            <h2 class="font-bold text-lg">Bölümler</h2>
                            <span class="text-xs text-gray-400">{{ $manga->chapters->count() }} Bölüm</span>
                        </div>
                        
                        <div class="max-h-[500px] overflow-y-auto custom-scrollbar divide-y divide-[#312f40]">
                            @forelse($manga->chapters as $chapter)
                                <div class="flex items-center justify-between px-5 py-3 hover:bg-white/5 transition-colors group">
                                    <a href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $chapter->chapter_number]) }}" class="flex-1 font-bold text-white group-hover:text-[#913FE2] transition-colors">
                                        Bölüm {{ $chapter->chapter_number }}
                                    </a>
                                    
                                    <div class="flex items-center gap-4">
                                        <span class="text-xs text-gray-500">{{ $chapter->created_at->diffForHumans() }}</span>
                                        
                                        <!-- Admin Bölüm Silme Butonu -->
                                        @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'uploader']))
                                            <form action="{{ route('admin.deleteChapter', $chapter->id) }}" method="POST" onsubmit="return confirm('Bu bölümü silmek istediğinize emin misiniz?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-400 text-lg" title="Bölümü Sil">🗑️</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="px-5 py-8 text-center text-gray-500 text-sm">
                                    Bu seriye henüz bölüm yüklenmedi.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SERİYİ DÜZENLE MODALI (Sadece Adminler İçin) -->
@if(Auth::check() && in_array(Auth::user()->role, ['admin', 'uploader']))
<div id="editModal" class="fixed inset-0 bg-black/80 z-[100] hidden items-center justify-center backdrop-blur-sm">
    <div class="bg-[#1D1B22] w-full max-w-lg rounded-2xl border border-[#312f40] shadow-2xl p-6 relative">
        <button onclick="document.getElementById('editModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-white text-xl">✖</button>
        <h2 class="text-xl font-bold text-white mb-4">Seriyi Düzenle</h2>
        
        <form action="{{ route('admin.updateSeries', $manga->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-bold text-gray-400 mb-1">Seri Adı</label>
                <input type="text" name="title" value="{{ $manga->title }}" required class="w-full bg-[#13111A] border border-[#312f40] text-white rounded-lg px-4 py-2 outline-none focus:border-purple-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-400 mb-1">Açıklama</label>
                <textarea name="description" rows="4" class="w-full bg-[#13111A] border border-[#312f40] text-white rounded-lg px-4 py-2 outline-none focus:border-purple-500">{{ $manga->description }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-400 mb-1">Yeni Kapak Resmi (Değiştirmek istemiyorsan boş bırak)</label>
                <input type="file" name="cover_image" accept="image/*" class="w-full text-xs text-gray-400 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:bg-[#312f40] file:text-white cursor-pointer">
            </div>
            <button type="submit" class="w-full py-3 mt-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors">Değişiklikleri Kaydet</button>
        </form>
    </div>
</div>
@endif
<script>
    const stars = document.querySelectorAll('.star');
    const msg = document.getElementById('rating-msg');
    let currentVote = 0; // Kullanıcının verdiği oy (veritabanından çekilebilir, şimdilik UI için)

    stars.forEach(star => {
        star.addEventListener('mouseover', function() {
            let val = this.getAttribute('data-value');
            stars.forEach(s => {
                if(s.getAttribute('data-value') <= val) s.classList.replace('text-gray-600', 'text-yellow-400');
                else s.classList.replace('text-yellow-400', 'text-gray-600');
            });
        });

        star.addEventListener('mouseout', function() {
            stars.forEach(s => {
                if(s.getAttribute('data-value') <= currentVote) s.classList.replace('text-gray-600', 'text-yellow-400');
                else s.classList.replace('text-yellow-400', 'text-gray-600');
            });
        });

        sstar.addEventListener('click', async function() {
            let score = this.getAttribute('data-value');
            
            try {
                let res = await fetch("{{ route('manga.rate', $manga->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ score: score })
                });
                
                let data = await res.json();
                msg.classList.remove('hidden');

                // Giriş yapmamışsa veya hata varsa
                if(res.status === 401 || !data.success) {
                    msg.classList.replace('text-green-400', 'text-red-400');
                    msg.innerText = data.error || "Giriş yapmanız gerekiyor.";
                    return;
                }
                
                // Başarılıysa
                currentVote = score; 
                stars.forEach(s => {
                    if(s.getAttribute('data-value') <= currentVote) s.classList.replace('text-gray-600', 'text-yellow-400');
                    else s.classList.replace('text-yellow-400', 'text-gray-600');
                });
                
                msg.classList.replace('text-red-400', 'text-green-400');
                msg.innerText = "Puanınız güncellendi!";
                document.getElementById('rating-display').innerText = "★ " + data.new_rating;
                document.getElementById('rating-count-display').innerText = data.count + " Oy";
                
            } catch(e) {
                console.error(e);
            }
        });
    });
</script>
@endsection