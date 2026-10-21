<!DOCTYPE html>
<html lang="id" class="h-full bg-pink-50/60">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Info Loker UMKM - Portal Lowongan Kerja Terpercaya')</title>
    @yield('meta')

    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Outfit"', '"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        pastel: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            300: '#fda4af',
                            400: '#fb7185',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                            800: '#9f1239',
                            900: '#881337',
                        }
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        
        /* Hide scrollbars cross-browser */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .hero-pink-gradient {
            background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 45%, #fecdd3 100%);
        }

        .card-pink-shadow {
            box-shadow: 0 16px 40px -10px rgba(244, 63, 94, 0.18);
        }

        .card-premium-glow {
            box-shadow: 0 20px 50px -10px rgba(251, 146, 60, 0.3);
        }
    </style>
</head>
<body class="flex flex-col min-h-full font-sans antialiased text-slate-800 bg-pink-50/50 selection:bg-pink-400 selection:text-white">

    <!-- Header / Navigation (Huge Wide Layout) -->
    <header class="sticky top-0 z-50 w-full border-b border-pink-200/80 glass-header">
        <div class="w-full max-w-[1700px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-20">
            <div class="flex items-center justify-between h-28">
                
                <!-- Logo Extra Huge -->
                <a href="{{ route('home') }}" class="flex items-center gap-4 group">
                    <div class="w-14 h-14 p-3.5 rounded-2xl bg-gradient-to-tr from-pink-500 via-rose-400 to-pink-400 flex items-center justify-center shadow-xl shadow-pink-500/35 group-hover:scale-105 transition-transform duration-300">
                        <i class="fa-solid fa-briefcase text-white text-3xl"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-none">
                            Loker<span class="bg-gradient-to-r from-pink-500 to-rose-500 bg-clip-text text-transparent">UMKM</span>
                        </span>
                        <span class="text-xs font-black tracking-widest text-pink-500 uppercase mt-1">Portal Kerja Terpercaya</span>
                    </div>
                </a>

                <!-- Nav Right Buttons Extra Huge -->
                <div class="flex items-center gap-4 sm:gap-6">
                    <a href="{{ route('home') }}" class="px-6 py-3.5 rounded-2xl text-base font-black text-slate-800 hover:text-pink-600 hover:bg-pink-100/70 transition-all hidden sm:inline-flex items-center gap-2.5">
                        <i class="fa-solid fa-house text-pink-500 text-lg"></i> Beranda
                    </a>
                    
                    @auth
                        @if(auth()->user()->isSuperAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-5 py-3 rounded-2xl text-sm font-black text-amber-950 bg-amber-100 hover:bg-amber-200 transition-all border-2 border-amber-300 flex items-center gap-2 shadow-md">
                                <i class="fa-solid fa-shield-halved text-amber-600"></i> Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('business.dashboard') }}" class="px-5 py-3 rounded-2xl text-sm font-black text-pink-700 bg-pink-100 hover:bg-pink-200 transition-all border-2 border-pink-300 flex items-center gap-2 shadow-md">
                                <i class="fa-solid fa-store text-pink-500"></i> Dashboard Saya
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-3 rounded-2xl text-sm font-black text-slate-600 hover:text-red-600 hover:bg-red-50 transition-all border-2 border-slate-200 flex items-center gap-2">
                                <i class="fa-solid fa-right-from-bracket"></i> Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-3 rounded-2xl text-sm font-black text-slate-700 hover:text-pink-600 hover:bg-pink-100/60 transition-all hidden md:inline-flex items-center gap-2">
                            <i class="fa-solid fa-right-to-bracket text-pink-500"></i> Masuk Usaha
                        </a>
                    @endauth

                    <!-- Bookmark Button -->
                    <button x-data @click="$dispatch('open-bookmark-modal')" class="px-5 py-3 rounded-2xl text-sm font-black text-rose-600 bg-rose-50 hover:bg-rose-100 transition-all inline-flex items-center gap-2 border border-rose-200">
                        <i class="fa-solid fa-heart"></i> Tersimpan
                    </button>

                    <!-- Pasang Loker Button -->
                    @auth
                        @if(auth()->user()->isPemilikUsaha())
                            <a href="{{ route('business.jobs.create') }}" class="inline-flex items-center gap-2 px-6 py-3.5 text-sm font-black text-white bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 hover:from-pink-600 hover:to-rose-600 rounded-2xl shadow-lg shadow-pink-500/35 hover:shadow-pink-500/50 transition-all transform hover:-translate-y-0.5">
                                <i class="fa-solid fa-plus-circle"></i> Pasang Loker
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3.5 text-sm font-black text-white bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 hover:from-pink-600 hover:to-rose-600 rounded-2xl shadow-lg shadow-pink-500/35 hover:shadow-pink-500/50 transition-all transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-plus-circle"></i> Pasang Loker
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </header>

    <!-- Flash Message Notification -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="w-full max-w-[1700px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 mt-6">
            <div class="flex items-center justify-between p-6 bg-emerald-50 border-2 border-emerald-400 text-emerald-950 rounded-3xl shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-lg shadow-emerald-500/40">
                        <i class="fa-solid fa-check text-2xl"></i>
                    </div>
                    <p class="text-base sm:text-lg font-black">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-600 hover:text-emerald-900 p-2 transition-colors">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="w-full max-w-[1700px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 mt-6">
            <div class="p-6 bg-rose-50 border-2 border-rose-400 text-rose-950 rounded-3xl shadow-lg">
                <div class="flex items-center gap-3 font-black text-lg mb-2 text-rose-900">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 text-2xl"></i>
                    <span>Terdapat isian yang perlu diperbaiki:</span>
                </div>
                <ul class="list-disc list-inside text-base font-bold space-y-1.5 pl-2 text-rose-800">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Extra Huge -->
    <footer class="mt-32 bg-slate-900 text-slate-300 border-t-2 border-pink-200/20">
        <div class="w-full max-w-[1700px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 py-20">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
                
                <div class="md:col-span-5 space-y-5">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-pink-500 to-rose-500 text-white flex items-center justify-center font-black text-2xl shadow-xl shadow-pink-500/40">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <span class="text-4xl font-black text-white tracking-tight">Loker<span class="text-pink-400">UMKM</span></span>
                    </div>
                    <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-lg font-semibold">
                        Platform direktori lowongan kerja UMKM dengan tampilan cantik & segar. Membantu UMKM menemukan pekerja lokal terbaik secara mudah via WhatsApp.
                    </p>
                    <div class="flex items-center gap-5 pt-3">
                        <span class="w-12 h-12 rounded-2xl bg-slate-800 border border-slate-700 flex items-center justify-center text-xl text-pink-400 hover:bg-pink-500 hover:text-white transition-all shadow-md">
                            <i class="fa-brands fa-instagram"></i>
                        </span>
                        <span class="w-12 h-12 rounded-2xl bg-slate-800 border border-slate-700 flex items-center justify-center text-xl text-pink-400 hover:bg-pink-500 hover:text-white transition-all shadow-md">
                            <i class="fa-brands fa-tiktok"></i>
                        </span>
                        <span class="w-12 h-12 rounded-2xl bg-slate-800 border border-slate-700 flex items-center justify-center text-xl text-emerald-400 hover:bg-emerald-500 hover:text-white transition-all shadow-md">
                            <i class="fa-brands fa-whatsapp"></i>
                        </span>
                    </div>
                </div>

                <div class="md:col-span-3 space-y-5">
                    <h4 class="text-sm font-black text-pink-400 uppercase tracking-widest">Navigasi Utama</h4>
                    <ul class="space-y-3.5 text-base font-bold">
                        <li><a href="{{ route('home') }}" class="hover:text-pink-300 transition-colors flex items-center gap-3"><i class="fa-solid fa-chevron-right text-sm text-pink-400"></i> Cari Lowongan</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-pink-300 transition-colors flex items-center gap-3"><i class="fa-solid fa-chevron-right text-sm text-pink-400"></i> Pasang Loker UMKM</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-pink-300 transition-colors flex items-center gap-3"><i class="fa-solid fa-chevron-right text-sm text-pink-400"></i> Login Pemilik Usaha</a></li>
                    </ul>
                </div>

                <div class="md:col-span-4 space-y-5">
                    <h4 class="text-sm font-black text-pink-400 uppercase tracking-widest">Fitur Unggulan System</h4>
                    <ul class="space-y-3.5 text-base font-extrabold">
                        <li class="flex items-center gap-3.5"><i class="fa-solid fa-circle-check text-pink-400 text-xl"></i> Moderasi Verifikasi Bebas Penipuan</li>
                        <li class="flex items-center gap-3.5"><i class="fa-solid fa-circle-check text-pink-400 text-xl"></i> Prioritas Loker Premium Teratas</li>
                        <li class="flex items-center gap-3.5"><i class="fa-solid fa-circle-check text-emerald-400 text-xl"></i> Direct WA Redirect 1-Click</li>
                        <li class="flex items-center gap-3.5"><i class="fa-solid fa-circle-check text-pink-400 text-xl"></i> Pembersihan Otomatis > 30 Hari</li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-slate-800 mt-16 pt-10 flex flex-col sm:flex-row items-center justify-between gap-6 text-sm text-slate-400 font-bold">
                <p>&copy; {{ date('Y') }} Info Loker UMKM. Dibuat dengan cinta untuk Kemajuan UMKM Indonesia.</p>
                <div class="flex items-center gap-8 text-base">
                    <span class="hover:text-white transition-colors">Privasi</span>
                    <span class="hover:text-white transition-colors">Ketentuan</span>
                    <span class="hover:text-white transition-colors">Bantuan</span>
                </div>
            </div>
        </div>
    </footer>
    </footer>

    <!-- Bookmark Modal -->
    <div x-data="{
            isOpen: false,
            savedJobs: [],
            init() {
                this.loadJobs();
                window.addEventListener('open-bookmark-modal', () => {
                    this.loadJobs();
                    this.isOpen = true;
                });
                window.addEventListener('jobs-bookmarked', () => {
                    this.loadJobs();
                });
            },
            loadJobs() {
                this.savedJobs = JSON.parse(localStorage.getItem('bookmarked_jobs') || '[]');
            },
            removeJob(id) {
                this.savedJobs = this.savedJobs.filter(j => j.id != id);
                localStorage.setItem('bookmarked_jobs', JSON.stringify(this.savedJobs));
                window.dispatchEvent(new CustomEvent('jobs-bookmarked'));
            }
        }"
        x-show="isOpen"
        x-cloak
        style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
        @keydown.escape.window="isOpen = false"
    >
        <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden flex flex-col max-h-[90vh]" @click.away="isOpen = false">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-gradient-to-r from-rose-50 to-white">
                <h3 class="text-xl font-black text-slate-800 flex items-center gap-3"><i class="fa-solid fa-heart text-rose-500"></i> Loker Tersimpan</h3>
                <button @click="isOpen = false" class="text-slate-400 hover:text-slate-600 w-8 h-8 rounded-full hover:bg-slate-100 flex items-center justify-center transition-all">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 bg-slate-50">
                <template x-if="savedJobs.length === 0">
                    <div class="text-center py-10">
                        <i class="fa-regular fa-folder-open text-5xl text-slate-300 mb-4 block"></i>
                        <p class="text-slate-500 font-bold">Belum ada loker yang disimpan.</p>
                        <p class="text-sm text-slate-400 mt-2">Klik tombol hati (❤️) pada loker untuk menyimpannya.</p>
                    </div>
                </template>
                <div class="space-y-4" x-show="savedJobs.length > 0">
                    <template x-for="job in savedJobs" :key="job.id">
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-rose-200 transition-all">
                            <div class="flex-1 min-w-0 pr-4">
                                <a :href="job.url" class="font-bold text-slate-800 hover:text-rose-600 truncate block text-lg" x-text="job.posisi"></a>
                                <p class="text-sm font-semibold text-slate-500 truncate flex items-center gap-2 mt-1">
                                    <i class="fa-solid fa-building text-slate-400"></i> <span x-text="job.perusahaan"></span>
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <a :href="job.url" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                                <button @click="removeJob(job.id)" class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-white text-center">
                <button @click="isOpen = false" class="px-6 py-2.5 rounded-xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all w-full">Tutup</button>
            </div>
        </div>
    </div>
</body>
</html>
