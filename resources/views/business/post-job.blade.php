@extends('layouts.app')

@section('title', 'Pasang Loker - ' . ($profile?->nama_usaha ?? 'LokerUMKM'))

@section('content')
<div class="w-full max-w-3xl mx-auto px-4 sm:px-6 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <a href="{{ route('business.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-pink-600 transition-colors mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-pink-500 to-rose-500 flex items-center justify-center shadow-lg shadow-pink-500/30">
                <i class="fa-solid fa-plus-circle text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900">Pasang Loker Baru</h1>
                <p class="text-slate-500 font-semibold text-sm">Data usaha otomatis terisi dari profil Anda</p>
            </div>
        </div>
    </div>

    {{-- Info profil sudah auto-filled --}}
    @if($profile && $profile->profil_lengkap)
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-4">
            <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shrink-0">
                <i class="fa-solid fa-circle-check text-white"></i>
            </div>
            <div>
                <p class="font-black text-emerald-800 text-sm">Data usaha sudah terisi otomatis!</p>
                <p class="text-emerald-700 font-semibold text-xs">
                    Loker akan atas nama <strong>{{ $profile->nama_usaha }}</strong> dengan kontak WA <strong>{{ $profile->no_hp }}</strong>
                </p>
            </div>
            <a href="{{ route('business.profile.edit') }}" class="ml-auto text-xs font-black text-emerald-600 hover:text-emerald-800 whitespace-nowrap">
                <i class="fa-solid fa-pen-to-square mr-1"></i>Edit
            </a>
        </div>
    @endif

    <form action="{{ route('business.jobs.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
        @csrf

        {{-- ── Info Posisi & Kategori ──────────────────────────────── --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <h2 class="text-base font-black text-slate-900 mb-5 pb-3 border-b border-pink-100">
                <i class="fa-solid fa-briefcase text-pink-500 mr-2"></i>Informasi Posisi
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wide">
                        Posisi / Jabatan yang Dibutuhkan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="posisi" id="posisi" value="{{ old('posisi') }}" required
                        placeholder="Contoh: Kasir, Chef, Admin Social Media, Driver..."
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all">
                    @error('posisi')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wide">
                        Kategori <span class="text-rose-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wide">
                        Tipe Pekerjaan <span class="text-rose-500">*</span>
                    </label>
                    <select name="tipe_pekerjaan" id="tipe_pekerjaan" required
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all bg-white">
                        @foreach(['Full Time', 'Part Time', 'Freelance', 'Magang'] as $tipe)
                            <option value="{{ $tipe }}" {{ old('tipe_pekerjaan') === $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wide">
                        Lokasi Kerja <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $profile?->alamat_usaha) }}" required
                        placeholder="Kota atau Kecamatan"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all">
                    @error('lokasi')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wide">Gaji / Upah (Opsional)</label>
                    <input type="text" name="gaji" id="gaji" value="{{ old('gaji') }}"
                        placeholder="Rp 2.000.000 / Sesuai UMR / Nego"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all">
                </div>
            </div>
        </div>

        </div>

        {{-- ── Opsi Premium (Opsional) ────────────────────────────────── --}}
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-3xl p-6 border-2 border-amber-200 shadow-sm" x-data="{ isPremium: false }">
            <h2 class="text-base font-black text-amber-900 mb-5 pb-3 border-b border-amber-200 flex items-center">
                <i class="fa-solid fa-crown text-amber-500 mr-2"></i> Jadikan Loker Premium?
            </h2>
            
            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" name="is_premium" value="1" x-model="isPremium" class="w-5 h-5 mt-0.5 rounded text-amber-500 focus:ring-amber-500">
                <div>
                    <span class="block font-black text-amber-900 text-sm">Ya, jadikan Premium (Rp 50.000)</span>
                    <p class="text-xs font-semibold text-amber-700 mt-1">Loker premium akan selalu tampil di urutan teratas pencarian dan ditandai dengan badge khusus yang lebih menarik perhatian pelamar.</p>
                </div>
            </label>

            <div x-show="isPremium" x-collapse class="mt-4 pt-4 border-t border-amber-200">
                <div class="bg-white p-4 rounded-2xl border border-amber-100 text-sm font-semibold text-amber-800 mb-4">
                    Silakan transfer ke rekening <strong>BCA 1234567890 a.n. Info Loker UMKM</strong> sebesar <strong>Rp 50.000</strong> dan unggah bukti transfer di bawah ini.
                </div>
                
                <label class="block text-xs font-black text-amber-900 mb-1.5 uppercase tracking-wide">
                    Upload Bukti Pembayaran <span class="text-rose-500">*</span>
                </label>
                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/jpeg,image/png,image/jpg" :required="isPremium"
                    class="w-full px-4 py-3 bg-white rounded-2xl border-2 border-amber-200 focus:border-amber-400 focus:outline-none focus:ring-4 focus:ring-amber-100 font-semibold text-slate-800 text-sm transition-all">
                <p class="text-xs text-amber-700 mt-1.5 font-semibold">Format JPG/PNG, maksimal 2MB.</p>
                @error('bukti_pembayaran')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- ── Deskripsi & Syarat ──────────────────────────────────── --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <h2 class="text-base font-black text-slate-900 mb-5 pb-3 border-b border-pink-100">
                <i class="fa-solid fa-file-lines text-pink-500 mr-2"></i>Detail Pekerjaan
            </h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wide">
                        Deskripsi Pekerjaan <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="5" required
                        placeholder="Jelaskan tugas dan tanggung jawab pekerjaan ini secara detail...
Contoh:
- Melayani pelanggan di kasir
- Mengelola transaksi penjualan
- Menjaga kebersihan area kasir"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all resize-none">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wide">
                        Syarat & Kualifikasi <span class="text-slate-400 font-semibold text-xs">(Opsional)</span>
                    </label>
                    <textarea name="syarat" id="syarat" rows="4"
                        placeholder="Contoh:
- Min. SMA/SMK sederajat
- Pengalaman tidak diperlukan
- Ramah dan bertanggung jawab
- Domisili dekat lokasi usaha"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all resize-none">{{ old('syarat') }}</textarea>
                </div>
            </div>
        </div>

        {{-- ── Info auto-filled ────────────────────────────────────── --}}
        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
            <p class="text-xs font-black text-slate-600 mb-2">
                <i class="fa-solid fa-robot text-pink-500 mr-1"></i>Data berikut diisi otomatis dari profil usaha Anda:
            </p>
            <div class="grid grid-cols-2 gap-2 text-xs font-semibold text-slate-500">
                <div><i class="fa-solid fa-store text-pink-400 mr-1"></i> <strong>Nama Usaha:</strong> {{ $profile?->nama_usaha ?? '—' }}</div>
                <div><i class="fa-brands fa-whatsapp text-emerald-500 mr-1"></i> <strong>Kontak WA:</strong> {{ $profile?->no_hp ?? '—' }}</div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex gap-3">
            <button type="submit" id="btn-post-job" class="flex-1 py-4 bg-gradient-to-r from-pink-500 to-rose-500 text-white font-black rounded-2xl hover:from-pink-600 hover:to-rose-600 shadow-lg shadow-pink-500/30 transition-all transform hover:-translate-y-0.5 text-sm">
                <i class="fa-solid fa-paper-plane mr-2"></i> Kirim untuk Ditinjau Admin
            </button>
            <a href="{{ route('business.dashboard') }}" class="px-6 py-4 bg-slate-100 text-slate-700 font-black rounded-2xl hover:bg-slate-200 transition-all text-sm flex items-center">
                Batal
            </a>
        </div>

        <p class="text-center text-xs font-semibold text-slate-400">
            <i class="fa-solid fa-shield-halved text-pink-400 mr-1"></i>
            Loker akan ditinjau oleh admin sebelum ditayangkan. Proses moderasi biasanya 1×24 jam.
        </p>
    </form>
</div>
@endsection
