<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MangaSitesi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#0D0B0E] text-white/90 font-sans antialiased min-h-screen overflow-x-hidden flex flex-col">

    <!-- SABİT NAVBAR -->
    <header class="bg-[#1D1B22] py-2 border-b border-white/[0.06] sticky top-0 z-40 shadow-md">
        <div class="max-w-[1280px] flex mx-auto px-4 items-center justify-between gap-5">
            <div class="flex items-center gap-2">
                <a class="flex h-10 w-10 items-center justify-center bg-purple-600 rounded-full font-bold text-white" href="/">GB</a>
                <ul class="hidden md:flex flex-row items-center gap-1">
                    <li><a href="/" class="px-3 py-2 text-[13px] font-medium text-white/90 hover:bg-[#913FE2] transition-colors rounded-md {{ request()->is('/') ? 'bg-[#913FE2]' : '' }}">Anasayfa</a></li>
                    <li><a href="/seriler" class="px-3 py-2 text-[13px] font-medium text-white/90 hover:bg-[#913FE2] transition-colors rounded-md {{ request()->is('seriler') ? 'bg-[#913FE2]' : '' }}">Seriler</a></li>
                    
                    <li class="relative group">
                        <button class="flex items-center gap-1 px-3 py-2 text-[13px] font-medium text-white/90 hover:bg-[#913FE2] transition-colors rounded-md {{ request()->is('trendler') ? 'bg-[#913FE2]' : '' }}">
                            Keşfet 
                            <svg class="w-3 h-3 opacity-60 group-hover:rotate-180 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="absolute top-full left-0 mt-1 w-44 bg-[#1A1823] border border-[#2a2835] rounded-xl shadow-2xl overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 z-50">
                            <a class="block px-4 py-2.5 text-[13px] text-white/80 hover:text-white hover:bg-[#913FE2]/20" href="/trendler">Trend Seriler</a>
                            <a class="block px-4 py-2.5 text-[13px] text-white/80 hover:text-white hover:bg-[#913FE2]/20" href="#">Sıralama</a>
                            <a class="block px-4 py-2.5 text-[13px] text-white/80 hover:text-white hover:bg-[#913FE2]/20" href="#">VIP Üyelik</a>
                        </div>
                    </li>
                </ul>
            </div>
            
            <div class="flex justify-end items-center gap-4">
                <input type="text" class="hidden md:block w-56 text-white px-4 py-1.5 rounded-lg border border-[#312f40] bg-[#13111A] outline-none focus:border-purple-500 text-sm" placeholder="Seri ara...">
                
                @auth
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-purple-400">{{ Auth::user()->name }}</span>
                        
                        <!-- ADMİN/UPLOADER BUTONU -->
                        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'uploader')
                            <a href="{{ route('admin.dashboard') }}" class="text-xs bg-purple-600/20 text-purple-400 hover:bg-purple-600/40 px-3 py-1.5 rounded-lg transition-colors font-bold border border-purple-500/30">
                                👑 Admin Paneli
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs bg-red-600/20 text-red-400 hover:bg-red-600/40 px-3 py-1.5 rounded-lg transition-colors border border-red-500/30">Çıkış</button>
                        </form>
                    </div>
                @else
                    <button onclick="openAuthModal('login')" class="h-9 px-4 bg-[#913FE2] text-white hover:bg-[#5a1f78] rounded-lg text-sm font-medium transition-colors">Giriş Yap</button>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    @guest
    <div id="authModal" class="fixed inset-0 bg-black/80 z-[100] hidden items-center justify-center backdrop-blur-sm transition-opacity">
        <div class="bg-[#1D1B22] w-full max-w-sm rounded-2xl border border-[#312f40] shadow-2xl p-6 relative">
            <button onclick="closeAuthModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-white mb-1">Gölge Bahçesi</h2>
                <p class="text-xs text-gray-400">Devam etmek için hesabınıza giriş yapın.</p>
            </div>

            <!-- Sekmeler -->
            <div class="flex p-1 bg-[#13111A] rounded-xl mb-5">
                <button id="tabLoginBtn" onclick="switchAuthTab('login')" class="flex-1 py-2 text-sm font-bold text-white bg-[#5a1f78] rounded-lg shadow">Giriş Yap</button>
                <button id="tabRegisterBtn" onclick="switchAuthTab('register')" class="flex-1 py-2 text-sm font-bold text-gray-500 hover:text-white rounded-lg">Kayıt Ol</button>
            </div>

            <!-- Hata / Başarı Alanı -->
            <div id="authErrors" class="hidden bg-red-500/10 border border-red-500/50 text-red-500 text-[11px] p-3 rounded-lg mb-4"></div>
            <div id="authSuccess" class="hidden bg-green-500/10 border border-green-500/50 text-green-500 text-sm font-bold p-3 rounded-lg mb-4 text-center"></div>

            <!-- Giriş Formu -->
            <form id="formLogin" action="{{ route('login') }}" onsubmit="submitAuthForm(event, 'login')" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5">E-posta</label>
                    <input type="email" name="email" required class="w-full bg-[#13111A] border border-[#312f40] text-white text-sm rounded-lg px-4 py-2.5 outline-none focus:border-[#913FE2]">
                </div>
                <div>
                    <div class="flex justify-between mb-1.5">
                        <label class="text-xs font-bold text-gray-300">Şifre</label>
                        <a href="#" class="text-xs text-gray-400 hover:text-white">Şifremi Unuttum</a>
                    </div>
                    <div class="relative">
                        <input type="password" name="password" required class="w-full bg-[#13111A] border border-[#312f40] text-white text-sm rounded-lg px-4 py-2.5 outline-none focus:border-[#913FE2] pr-10">
                        <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">👁️</button>
                    </div>
                </div>
                <button type="submit" class="w-full py-3 mt-2 bg-[#5a1f78] hover:bg-[#7a2cb3] text-white font-bold rounded-xl transition-colors">Giriş Yap</button>
            </form>

            <!-- Kayıt Formu -->
            <form id="formRegister" action="{{ route('register') }}" onsubmit="submitAuthForm(event, 'register')" class="hidden flex-col gap-3.5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1">Kullanıcı Adı</label>
                    <input type="text" name="name" required class="w-full bg-[#13111A] border border-[#312f40] text-white text-sm rounded-lg px-4 py-2 outline-none focus:border-[#913FE2]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1">E-posta</label>
                    <input type="email" name="email" required class="w-full bg-[#13111A] border border-[#312f40] text-white text-sm rounded-lg px-4 py-2 outline-none focus:border-[#913FE2]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1">Şifre</label>
                    <div class="relative">
                        <input type="password" name="password" required class="w-full bg-[#13111A] border border-[#312f40] text-white text-sm rounded-lg px-4 py-2 outline-none focus:border-[#913FE2] pr-10">
                        <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">👁️</button>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1">Şifreyi Onayla</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" required class="w-full bg-[#13111A] border border-[#312f40] text-white text-sm rounded-lg px-4 py-2 outline-none focus:border-[#913FE2] pr-10">
                        <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">👁️</button>
                    </div>
                </div>
                <button type="submit" class="w-full py-3 mt-2 bg-[#5a1f78] hover:bg-[#7a2cb3] text-white font-bold rounded-xl transition-colors">Kayıt Ol</button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('authModal');
        const loginForm = document.getElementById('formLogin');
        const registerForm = document.getElementById('formRegister');
        const loginBtn = document.getElementById('tabLoginBtn');
        const registerBtn = document.getElementById('tabRegisterBtn');

        function openAuthModal(tab = 'login') {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            switchAuthTab(tab);
        }

        function closeAuthModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function switchAuthTab(tab) {
            document.getElementById('authErrors').classList.add('hidden');
            document.getElementById('authSuccess').classList.add('hidden');

            if(tab === 'login') {
                loginForm.classList.remove('hidden');
                loginForm.classList.add('flex');
                registerForm.classList.add('hidden');
                registerForm.classList.remove('flex');
                
                loginBtn.classList.replace('text-gray-500', 'text-white');
                loginBtn.classList.replace('bg-transparent', 'bg-[#5a1f78]');
                registerBtn.classList.replace('text-white', 'text-gray-500');
                registerBtn.classList.replace('bg-[#5a1f78]', 'bg-transparent');
            } else {
                registerForm.classList.remove('hidden');
                registerForm.classList.add('flex');
                loginForm.classList.add('hidden');
                loginForm.classList.remove('flex');
                
                registerBtn.classList.replace('text-gray-500', 'text-white');
                registerBtn.classList.replace('bg-transparent', 'bg-[#5a1f78]');
                loginBtn.classList.replace('text-white', 'text-gray-500');
                loginBtn.classList.replace('bg-[#5a1f78]', 'bg-transparent');
            }
        }

        function togglePassword(button) {
            const input = button.previousElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                button.innerText = '🙈';
            } else {
                input.type = 'password';
                button.innerText = '👁️';
            }
        }

        async function submitAuthForm(event, type) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const errorDiv = document.getElementById('authErrors');
            const successDiv = document.getElementById('authSuccess');
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            errorDiv.classList.add('hidden');
            successDiv.classList.add('hidden');
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Bekleyin...';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                if (response.ok || response.redirected) {
                    form.classList.add('hidden');
                    document.querySelector('.flex.p-1.bg-\\[\\#13111A\\]').classList.add('hidden');
                    successDiv.classList.remove('hidden');
                    successDiv.innerHTML = type === 'login' ? '✓ Başarılı! Giriş yapılıyor...' : '✓ Kayıt başarılı! Yönlendiriliyor...';
                    setTimeout(() => window.location.reload(), 800);
                } else if (response.status === 422) {
                    const data = await response.json();
                    errorDiv.classList.remove('hidden');
                    errorDiv.innerHTML = Object.values(data.errors).map(err => `<p>• ${err[0]}</p>`).join('');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                } else {
                    errorDiv.classList.remove('hidden');
                    errorDiv.innerHTML = '<p>• Bilgiler hatalı veya kayıtlı değil.</p>';
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            } catch (error) {
                errorDiv.classList.remove('hidden');
                errorDiv.innerHTML = '<p>• Sunucu bağlantı hatası.</p>';
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        }
    </script>
    @endguest

</body>
</html>