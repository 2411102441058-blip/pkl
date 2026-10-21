@extends('layouts.app')

@section('title', 'Info Loker UMKM - Cari Lowongan Kerja Terpercaya & Terbaru')

@section('content')

<!-- Hero & Search Section (Ultra Huge & Wide Screen) -->
<section class="relative hero-pink-gradient text-slate-900 pt-20 pb-36 overflow-hidden border-b border-pink-200/50">
    
    <!-- Background Decorative Glows -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1300px] h-[500px] bg-pink-300/40 blur-[150px] rounded-full pointer-events-none"></div>
    <div class="absolute top-1/4 right-5 w-[600px] h-[400px] bg-rose-300/30 blur-[130px] rounded-full pointer-events-none"></div>

    <div class="relative w-full max-w-[1700px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 text-center">
        
        <!-- Top Badge Ultra Huge -->
        <div class="inline-flex items-center gap-3 px-7 py-3 rounded-full bg-white/95 border-2 border-pink-300 text-pink-700 text-sm sm:text-base font-black uppercase tracking-wider mb-10 shadow-md backdrop-blur-md">
            <i class="fa-solid fa-sparkles text-amber-500 text-xl"></i> Platform Lowongan Kerja UMKM Terverifikasi
        </div>

        <!-- Ultra Huge Hero Heading -->
        <h1 class="text-5xl sm:text-7xl lg:text-8xl font-black tracking-tight text-slate-900 max-w-7xl mx-auto leading-[1.1]">
            Temukan Pekerjaan Impian & Hubungi UMKM <span class="bg-gradient-to-r from-pink-600 via-rose-600 to-pink-500 bg-clip-text text-transparent">Langsung via WhatsApp</span>
        </h1>

        <!-- Subtitle Ultra Huge -->
        <p class="mt-8 text-xl sm:text-2xl lg:text-3xl text-slate-700 max-w-4xl mx-auto font-bold leading-relaxed">
            Lowongan kerja lokal bebas ribet! Tanpa perlu buat CV rumit, Anda bisa melamar ke pemilik usaha hanya dengan 1-klik via WhatsApp.
        </p>

        <!-- Search Form Floating Card Ultra Huge -->
        <div class="mt-14 max-w-6xl mx-auto">
            <form action="{{ route('home') }}" method="GET" class="bg-white/95 backdrop-blur-2xl p-5 sm:p-7 rounded-[32px] shadow-2xl shadow-pink-500/15 border-2 border-pink-300/80 text-slate-800 grid grid-cols-1 md:grid-cols-12 gap-3.5 items-center">
                
                <!-- Keyword Input -->
                <div class="md:col-span-4 relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-pink-400 text-xl">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Posisi (Guru, IT, Admin, Kasir...)" class="w-full pl-14 pr-4 py-4 bg-pink-50/60 hover:bg-pink-50 focus:bg-white border-2 border-pink-200 rounded-2xl text-sm sm:text-base font-extrabold text-slate-900 placeholder-slate-400 focus:ring-4 focus:ring-pink-300 focus:border-pink-500 outline-none transition-all">
                </div>

                <!-- Category Select -->
                <div class="md:col-span-3 relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-pink-400 text-xl">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <select name="kategori" class="w-full pl-14 pr-10 py-4 bg-pink-50/60 hover:bg-pink-50 focus:bg-white border-2 border-pink-200 rounded-2xl text-sm sm:text-base font-extrabold text-slate-900 focus:ring-4 focus:ring-pink-300 focus:border-pink-500 outline-none transition-all appearance-none cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('kategori') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->nama }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-pink-400 text-sm">
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </div>

                <!-- Location Select / Input (Indonesia Cities) -->
                <div class="md:col-span-3 relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-pink-400 text-xl">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <input type="text" name="lokasi" value="{{ request('lokasi') }}" list="kota-indonesia" placeholder="Lokasi di Indonesia..." class="w-full pl-14 pr-4 py-4 bg-pink-50/60 hover:bg-pink-50 focus:bg-white border-2 border-pink-200 rounded-2xl text-sm sm:text-base font-extrabold text-slate-900 placeholder-slate-400 focus:ring-4 focus:ring-pink-300 focus:border-pink-500 outline-none transition-all">
                    <datalist id="kota-indonesia">
                        <option value="Jakarta">
                        <option value="Bandung">
                        <option value="Surabaya">
                        <option value="Yogyakarta">
                        <option value="Semarang">
                        <option value="Medan">
                        <option value="Bali">
                        <option value="Malang">
                        <option value="Makassar">
                        <option value="Palembang">
                        <option value="Tangerang">
                        <option value="Bekasi">
                        <option value="Bogor">
                        <option value="Depok">
                        <option value="Solo">
                    </datalist>
                </div>

                <!-- Search Button -->
                <div class="md:col-span-2">
                    <button type="submit" class="w-full py-4 px-5 font-black text-white bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 hover:from-pink-600 hover:to-rose-600 rounded-2xl shadow-xl shadow-pink-500/35 transition-all transform active:scale-95 flex items-center justify-center gap-2 text-base tracking-wide">
                        <i class="fa-solid fa-search"></i>
                        <span>Cari</span>
                    </button>
                </div>

            </form>
        </div>

    </div>
</section>

<!-- Category Quick Filter Pills Ultra Huge -->
<section class="w-full max-w-[1700px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 -mt-11 relative z-20">
    <div class="bg-white rounded-[32px] p-5 shadow-2xl shadow-pink-500/10 border-2 border-pink-200/90 flex items-center gap-4 overflow-x-auto no-scrollbar scroll-smooth">
        
        <a href="{{ route('home') }}" class="px-7 py-4 rounded-2xl text-base font-black whitespace-nowrap transition-all flex items-center gap-3 shrink-0 {{ !request('kategori') ? 'bg-slate-900 text-white shadow-xl shadow-slate-900/30' : 'bg-pink-50 text-slate-800 hover:bg-pink-100 border border-pink-200' }}">
            <i class="fa-solid fa-border-all text-xl"></i> Semua Loker
        </a>

        @foreach($categories as $cat)
            <a href="{{ route('home', array_merge(request()->except('kategori'), ['kategori' => $cat->slug])) }}" class="px-7 py-4 rounded-2xl text-base font-black whitespace-nowrap transition-all flex items-center gap-3 shrink-0 {{ request('kategori') == $cat->slug ? 'bg-pink-600 text-white shadow-xl shadow-pink-600/35' : 'bg-pink-50 text-slate-800 hover:bg-pink-100 border border-pink-200' }}">
                <i class="fa-solid {{ $cat->icon }} text-xl text-pink-500 {{ request('kategori') == $cat->slug ? 'text-white' : '' }}"></i>
                <span>{{ $cat->nama }}</span>
                <span class="px-3 py-0.5 text-xs font-black rounded-full {{ request('kategori') == $cat->slug ? 'bg-white/30 text-white' : 'bg-pink-200 text-pink-950' }}">{{ $cat->job_listings_count }}</span>
            </a>
        @endforeach

    </div>
</section>

<!-- Active Job Listings Section Ultra Huge (FASE 3 Grid) -->
<section class="w-full max-w-[1700px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 py-20">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-12">
        <div>
            <h2 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">Daftar Lowongan Kerja Active</h2>
            <p class="text-base sm:text-lg text-pink-700 font-extrabold mt-1.5">Loker dengan prioritas <strong>Premium ⭐</strong> ditampilkan di paling atas.</p>
        </div>
        <div class="text-base font-black text-pink-900 bg-white border-2 border-pink-300 px-6 py-3.5 rounded-2xl shadow-md self-start sm:self-auto flex items-center gap-3">
            <i class="fa-solid fa-briefcase text-pink-500 text-xl"></i> Total: {{ $jobs->total() }} Lowongan Tayang
        </div>
    </div>

    @if($jobs->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-[32px] p-20 text-center border-2 border-pink-200 shadow-sm my-8">
            <div class="w-24 h-24 mx-auto rounded-3xl bg-pink-100 flex items-center justify-center text-pink-400 text-4xl mb-4">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <h3 class="text-2xl font-black text-slate-800">Tidak ada lowongan ditemukan</h3>
            <p class="text-base text-slate-500 font-semibold mt-2 max-w-md mx-auto">
                Coba ubah kata kunci pencarian atau pilih kategori lain untuk melihat lowongan kerja yang tersedia.
            </p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 mt-8 px-8 py-4 bg-slate-900 text-white text-base font-black rounded-2xl hover:bg-slate-800 transition-colors shadow-lg">
                <i class="fa-solid fa-rotate-left"></i> Reset Filter
            </a>
        </div>
    @else
        <!-- Jobs Grid - 3 Columns Extra Wide & Roomy -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 items-stretch">
            @foreach($jobs as $job)
                <div class="group bg-white rounded-[32px] border-2 transition-all duration-300 hover:-translate-y-2 flex flex-col justify-between overflow-hidden {{ $job->is_premium ? 'border-amber-400 card-premium-glow ring-4 ring-amber-300/40' : 'border-pink-100 shadow-xl card-pink-shadow hover:border-pink-300' }}">
                    
                    <!-- Card Top Header Ultra Huge -->
                    <div class="{{ $job->is_premium ? 'bg-gradient-to-r from-amber-400 via-amber-500 to-yellow-500 text-slate-950 font-black' : 'bg-pink-100/80 text-pink-900 font-black border-b border-pink-200/60' }} text-sm uppercase tracking-wider py-3.5 px-7 flex items-center justify-between">
                        @if($job->is_premium)
                            <span class="flex items-center gap-2 text-sm font-black">
                                <i class="fa-solid fa-crown text-amber-950 text-base"></i> LOKER PREMIUM
                            </span>
                            <span class="text-xs bg-slate-950/20 px-3 py-1 rounded-full font-black">⭐ Rekomendasi</span>
                        @else
                            <span class="flex items-center gap-2 text-sm font-black text-pink-800">
                                <i class="fa-solid fa-circle-check text-pink-500 text-base"></i> Loker Terverifikasi
                            </span>
                            <span class="text-xs text-pink-700 font-bold">{{ $job->created_at->diffForHumans() }}</span>
                        @endif
                    </div>

                    <!-- Card Body Ultra Huge -->
                    <div class="p-8 sm:p-9 flex-grow flex flex-col justify-between space-y-6">
                        
                        <div>
                            <!-- Category Badge & Date -->
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <span class="inline-flex items-center gap-2.5 text-xs sm:text-sm font-black text-pink-800 bg-pink-100/90 px-4 py-2 rounded-2xl border border-pink-200">
                                    <i class="fa-solid {{ $job->category->icon ?? 'fa-briefcase' }} text-pink-500 text-base"></i>
                                    <span>{{ $job->category->nama ?? 'Umum' }}</span>
                                </span>

                                @if($job->is_premium)
                                    <span class="text-xs font-bold text-slate-400">
                                        {{ $job->created_at->diffForHumans() }}
                                    </span>
                                @endif
                            </div>

                            <!-- Job Title Ultra Huge -->
                            <h3 class="text-2xl sm:text-3xl font-black text-slate-900 group-hover:text-pink-600 transition-colors line-clamp-1 leading-snug">
                                <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->posisi }}</a>
                            </h3>

                            <!-- Company Name Ultra Huge -->
                            <p class="text-base sm:text-lg font-extrabold text-pink-800 flex items-center gap-2.5 mt-2">
                                <i class="fa-solid fa-store text-pink-500 text-base"></i>
                                <span>{{ $job->nama_usaha }}</span>
                            </p>
                        </div>

                        <!-- Key Specs Pills Ultra Huge -->
                        <div class="pt-5 border-t border-pink-100 space-y-3 text-sm sm:text-base font-black text-slate-700">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-location-dot text-base"></i>
                                </div>
                                <span class="truncate">{{ $job->lokasi }}</span>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-clock text-base"></i>
                                </div>
                                <span>{{ $job->tipe_pekerjaan }}</span>
                            </div>

                            @if($job->gaji)
                                <div class="flex items-center gap-3 font-black text-emerald-700">
                                    <div class="w-8 h-8 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-money-bill-wave text-base"></i>
                                    </div>
                                    <span class="text-base sm:text-lg">{{ $job->gaji }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Short Description Preview -->
                        <p class="text-sm sm:text-base text-slate-600 line-clamp-2 leading-relaxed font-semibold">
                            {{ Str::limit(strip_tags($job->deskripsi), 95) }}
                        </p>

                    </div>

                    <!-- Card Actions Ultra Huge -->
                    <div class="p-6 bg-pink-50/70 border-t border-pink-100 grid grid-cols-2 gap-4">
                        <a href="{{ route('jobs.show', $job->slug) }}" class="py-4 px-4 bg-white hover:bg-pink-100/60 text-pink-950 text-sm sm:text-base font-black rounded-2xl border-2 border-pink-200 text-center transition-colors shadow-sm">
                            Detail Loker
                        </a>
                        
                        <!-- FASE 3 WA Direct Trigger -->
                        <a href="{{ $job->wa_link }}" target="_blank" class="inline-flex items-center justify-center gap-2.5 py-4 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-sm sm:text-base font-black rounded-2xl shadow-lg shadow-emerald-600/30 transition-all hover:scale-[1.02]">
                            <i class="fa-brands fa-whatsapp text-xl"></i>
                            <span>Lamar WA</span>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-14">
            {{ $jobs->links() }}
        </div>
    @endif

</section>

@endsection
