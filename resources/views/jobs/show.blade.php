@extends('layouts.app')

@section('title', $job->posisi . ' - ' . $job->nama_usaha . ' | Info Loker UMKM')

@section('meta')
    <meta property="og:title" content="{{ $job->posisi }} di {{ $job->nama_usaha }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($job->deskripsi), 150) }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('jobs.show', $job->slug) }}">
    <meta property="og:image" content="{{ asset('images/loker-default-og.png') }}">
@endsection

@section('content')

<!-- Header Breadcrumb & Banner (Ultra Huge Wide Screen) -->
<div class="hero-pink-gradient text-slate-900 pt-16 pb-28 relative overflow-hidden border-b border-pink-200/50">
    <div class="absolute top-0 right-0 w-[600px] h-[350px] bg-pink-300/40 blur-[130px] rounded-full pointer-events-none"></div>

    <div class="w-full max-w-[1700px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 relative z-10">
        
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2.5 text-sm sm:text-base font-bold text-slate-600 mb-8">
            <a href="{{ route('home') }}" class="hover:text-pink-600 transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs text-pink-400"></i>
            <span class="text-slate-700">{{ $job->category->nama ?? 'Loker' }}</span>
            <i class="fa-solid fa-chevron-right text-xs text-pink-400"></i>
            <span class="text-pink-600 font-black truncate max-w-sm">{{ $job->posisi }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <div class="space-y-4">
                <div class="flex flex-wrap items-center gap-3 mb-3">
                    @if($job->is_premium)
                        <span class="px-4 py-1.5 bg-gradient-to-r from-amber-400 to-yellow-500 text-slate-950 text-xs sm:text-sm font-black rounded-full uppercase tracking-wider shadow-md">
                            <i class="fa-solid fa-crown mr-1.5"></i> Loker Premium ⭐
                        </span>
                    @endif
                    <span class="px-4 py-1.5 bg-white/90 text-pink-800 text-xs sm:text-sm font-black rounded-full border border-pink-300 shadow-sm">
                        <i class="fa-solid {{ $job->category->icon ?? 'fa-briefcase' }} mr-1.5 text-pink-500"></i> {{ $job->category->nama ?? 'Umum' }}
                    </span>
                    <span class="px-4 py-1.5 bg-pink-100 text-pink-900 text-xs sm:text-sm font-black rounded-full border border-pink-200">
                        {{ $job->tipe_pekerjaan }}
                    </span>
                </div>

                <h1 class="text-4xl sm:text-6xl font-black text-slate-900 leading-tight">
                    {{ $job->posisi }}
                </h1>
                
                <p class="text-xl sm:text-2xl font-black text-pink-600 flex items-center gap-2.5 pt-1">
                    <i class="fa-solid fa-store text-pink-500"></i>
                    <span>{{ $job->nama_usaha }}</span>
                </p>
            </div>

            <!-- Floating Quick Contact Ultra Huge -->
            <div class="bg-white/95 backdrop-blur-2xl p-7 rounded-[32px] border-2 border-pink-200 flex flex-col items-center justify-center shrink-0 text-center shadow-2xl">
                <span class="text-sm sm:text-base text-slate-700 font-bold">Lamar Pekerjaan Ini</span>
                <a href="{{ $job->wa_link }}" target="_blank" data-job-id="{{ $job->id }}" class="apply-btn mt-4 inline-flex items-center gap-3 px-8 py-4.5 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-base sm:text-lg rounded-2xl shadow-xl shadow-emerald-600/30 transition-all transform hover:scale-105 w-full justify-center">
                    <i class="fa-brands fa-whatsapp text-3xl"></i>
                    <span>Lamar via WhatsApp</span>
                </a>
                
                <div class="flex items-center gap-3 w-full mt-4">
                    <button x-data="{
                                isSaved: false,
                                init() {
                                    let saved = JSON.parse(localStorage.getItem('bookmarked_jobs') || '[]');
                                    this.isSaved = saved.some(j => j.id == {{ $job->id }});
                                    window.addEventListener('jobs-bookmarked', () => {
                                        let saved = JSON.parse(localStorage.getItem('bookmarked_jobs') || '[]');
                                        this.isSaved = saved.some(j => j.id == {{ $job->id }});
                                    });
                                },
                                toggleSave() {
                                    let saved = JSON.parse(localStorage.getItem('bookmarked_jobs') || '[]');
                                    if (this.isSaved) {
                                        saved = saved.filter(j => j.id != {{ $job->id }});
                                    } else {
                                        saved.push({
                                            id: {{ $job->id }},
                                            posisi: '{{ addslashes($job->posisi) }}',
                                            perusahaan: '{{ addslashes($job->nama_usaha) }}',
                                            url: '{{ route('jobs.show', $job->slug) }}'
                                        });
                                    }
                                    localStorage.setItem('bookmarked_jobs', JSON.stringify(saved));
                                    this.isSaved = !this.isSaved;
                                    window.dispatchEvent(new CustomEvent('jobs-bookmarked'));
                                }
                            }" 
                            @click="toggleSave()"
                            :class="isSaved ? 'bg-rose-500 text-white border-rose-500' : 'bg-rose-50 text-rose-500 border-rose-200 hover:bg-rose-100'"
                            class="flex-1 py-3 rounded-xl font-bold text-sm transition-all border inline-flex items-center justify-center gap-2">
                        <i class="fa-solid fa-heart"></i> <span x-text="isSaved ? 'Tersimpan' : 'Simpan Loker'"></span>
                    </button>
                    
                    <button x-data="{
                                share() {
                                    let url = '{{ route('jobs.show', $job->slug) }}';
                                    let text = 'Lowongan {{ addslashes($job->posisi) }} di {{ addslashes($job->nama_usaha) }} \nLihat selengkapnya di: ' + url;
                                    let waUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(text);
                                    window.open(waUrl, '_blank');
                                }
                            }" 
                            @click="share()"
                            class="flex-1 py-3 bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 rounded-xl font-bold text-sm transition-all inline-flex items-center justify-center gap-2">
                        <i class="fa-solid fa-share-nodes"></i> Bagikan
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Details & Description Ultra Huge -->
<div class="w-full max-w-[1700px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 -mt-12 mb-32 relative z-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Main Info (Left 8 cols) -->
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white rounded-[32px] p-8 sm:p-12 shadow-2xl border-2 border-pink-200/90">
                
                <h3 class="text-xl sm:text-2xl font-black text-slate-900 border-b-2 border-pink-100 pb-4 mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-file-lines text-pink-500"></i> Deskripsi Pekerjaan
                </h3>

                <div class="text-base sm:text-lg text-slate-700 leading-relaxed whitespace-pre-line font-medium">
                    {{ $job->deskripsi }}
                </div>

                @if($job->syarat)
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 border-b-2 border-pink-100 pb-4 mb-6 mt-12 flex items-center gap-3">
                        <i class="fa-solid fa-list-check text-pink-500"></i> Persyaratan Pelamar
                    </h3>
                    <div class="text-base sm:text-lg text-slate-700 leading-relaxed whitespace-pre-line font-medium">
                        {{ $job->syarat }}
                    </div>
                @endif

                <!-- Big Apply CTA -->
                <div class="mt-14 p-10 bg-gradient-to-r from-pink-50 via-rose-50 to-pink-50 rounded-[32px] border-2 border-pink-200 text-center">
                    <h4 class="text-xl sm:text-2xl font-black text-pink-950">Tertarik mengisi posisi ini?</h4>
                    <p class="text-base text-pink-800 font-semibold mt-2 max-w-lg mx-auto">
                        Klik tombol di bawah untuk membuka aplikasi WhatsApp dengan pesan otomatis langsung ke kontak pemilik usaha.
                    </p>
                    <a href="{{ $job->wa_link }}" target="_blank" data-job-id="{{ $job->id }}" class="apply-btn inline-flex items-center gap-3.5 mt-7 px-10 py-5 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-lg sm:text-xl rounded-2xl shadow-xl shadow-emerald-600/35 transition-all transform hover:scale-105">
                        <i class="fa-brands fa-whatsapp text-4xl"></i>
                        <span>Kirim Lamaran Sekarang (WA)</span>
                    </a>
                </div>

            </div>
        </div>

        <!-- Sidebar Info Ultra Huge (Right 4 cols) -->
        <div class="lg:col-span-4 space-y-8">
            <div class="bg-white rounded-[32px] p-8 shadow-2xl border-2 border-pink-200/90 space-y-6 text-base">
                <h3 class="font-black text-slate-900 text-xl border-b-2 border-pink-100 pb-4">Ringkasan Loker</h3>
                
                <div>
                    <span class="text-slate-400 font-black text-xs uppercase tracking-wider block">Nama UMKM / Usaha:</span>
                    <span class="font-black text-slate-900 text-lg sm:text-xl">{{ $job->nama_usaha }}</span>
                </div>

                <div>
                    <span class="text-slate-400 font-black text-xs uppercase tracking-wider block">Lokasi:</span>
                    <span class="font-extrabold text-slate-800 text-base sm:text-lg flex items-center gap-2 mt-0.5">
                        <i class="fa-solid fa-location-dot text-rose-500"></i> {{ $job->lokasi }}
                    </span>
                </div>

                <div>
                    <span class="text-slate-400 font-black text-xs uppercase tracking-wider block">Tipe Pekerjaan:</span>
                    <span class="font-extrabold text-slate-800 text-base sm:text-lg">{{ $job->tipe_pekerjaan }}</span>
                </div>

                @if($job->gaji)
                    <div>
                        <span class="text-slate-400 font-black text-xs uppercase tracking-wider block">Penawaran Gaji:</span>
                        <span class="font-black text-emerald-700 text-lg sm:text-xl">{{ $job->gaji }}</span>
                    </div>
                @endif

                <div>
                    <span class="text-slate-400 font-black text-xs uppercase tracking-wider block">Tanggal Tayang:</span>
                    <span class="font-bold text-slate-700 text-base">{{ $job->approved_at ? $job->approved_at->format('d M Y') : $job->created_at->format('d M Y') }}</span>
                </div>

                <div>
                    <span class="text-slate-400 font-black text-xs uppercase tracking-wider block">Nomor WhatsApp:</span>
                    <span class="font-mono font-bold text-emerald-700 bg-emerald-50 px-4 py-2 rounded-2xl border border-emerald-200 inline-block mt-1 text-base">{{ $job->nomor_wa }}</span>
                </div>
            </div>

            <!-- Security Alert -->
            <div class="bg-pink-100/80 rounded-[32px] p-6 border-2 border-pink-300 text-sm sm:text-base text-pink-950 font-bold">
                <strong class="font-black flex items-center gap-2.5 text-pink-900 mb-1.5 text-base">
                    <i class="fa-solid fa-shield-halved text-pink-600 text-xl"></i> Hati-Hati Penipuan!
                </strong>
                Info Loker UMKM tidak pernah meminta biaya apapun dari pelamar kerja. Jangan pernah mentransfer uang untuk alasan apapun!
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const applyBtns = document.querySelectorAll('.apply-btn');
        applyBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const jobId = this.getAttribute('data-job-id');
                fetch(`/loker/${jobId}/track-click`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }).catch(err => console.error('Error tracking click:', err));
            });
        });
    });
</script>

@endsection
