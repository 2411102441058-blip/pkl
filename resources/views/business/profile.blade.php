@extends('layouts.app')

@section('title', 'Profil Usaha - LokerUMKM')

@section('content')
<div class="w-full max-w-3xl mx-auto px-4 sm:px-6 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <a href="{{ route('business.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-pink-600 transition-colors mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-pink-500 to-rose-500 flex items-center justify-center shadow-lg shadow-pink-500/30">
                <i class="fa-solid fa-store text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900">Profil Usaha</h1>
                <p class="text-slate-500 font-semibold text-sm">Data ini diisi sekali dan dipakai otomatis saat posting loker</p>
            </div>
        </div>
    </div>

    {{-- Info penting --}}
    @if(!$profile->profil_lengkap || !$profile->exists)
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-2xl">
            <p class="text-blue-800 font-bold text-sm flex items-start gap-2">
                <i class="fa-solid fa-circle-info text-blue-500 mt-0.5 shrink-0"></i>
                Lengkapi profil Anda. Setelah terisi, saat posting loker berikutnya nama usaha & nomor WA akan terisi otomatis — Anda tidak perlu mengisi ulang.
            </p>
        </div>
    @endif

    <form action="{{ route('business.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- ── Data Pemilik ──────────────────────────────────────────── --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <h2 class="text-base font-black text-slate-900 mb-5 pb-3 border-b border-pink-100">
                <i class="fa-solid fa-user text-pink-500 mr-2"></i>Data Pemilik
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wide">
                        Nama Pemilik <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_pemilik" id="nama_pemilik" value="{{ old('nama_pemilik', $profile->nama_pemilik) }}" required
                        placeholder="Nama lengkap pemilik usaha"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all">
                    @error('nama_pemilik')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- ── Data Usaha ────────────────────────────────────────────── --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <h2 class="text-base font-black text-slate-900 mb-5 pb-3 border-b border-pink-100">
                <i class="fa-solid fa-store text-pink-500 mr-2"></i>Data Usaha
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wide">
                        Nama Usaha <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_usaha" id="nama_usaha" value="{{ old('nama_usaha', $profile->nama_usaha) }}" required
                        placeholder="Nama usaha/toko"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all">
                    @error('nama_usaha')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wide">
                        Nomor HP / WA <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $profile->no_hp) }}" required
                        placeholder="08xxxxxxxxxx"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all">
                    <p class="text-xs text-slate-400 font-semibold mt-1">Dipakai untuk redirect WA pelamar</p>
                    @error('no_hp')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wide">Kategori Usaha</label>
                    <select name="kategori_usaha" id="kategori_usaha"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(['Kuliner & F&B', 'Fashion & Clothing', 'Kerajinan Tangan', 'Teknologi & Digital', 'Jasa & Layanan', 'Retail & Toko', 'Pertanian & Peternakan', 'Pendidikan & Pelatihan', 'Kesehatan & Kecantikan', 'Lainnya'] as $kat)
                            <option value="{{ $kat }}" {{ old('kategori_usaha', $profile->kategori_usaha) === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wide">Website (Opsional)</label>
                    <input type="url" name="website" id="website" value="{{ old('website', $profile->website) }}"
                        placeholder="https://usahaanda.com"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all">
                    @error('website')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wide">Alamat Usaha</label>
                    <input type="text" name="alamat_usaha" id="alamat_usaha" value="{{ old('alamat_usaha', $profile->alamat_usaha) }}"
                        placeholder="Jl. Contoh No.1, Kota"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wide">Deskripsi Usaha (Opsional)</label>
                    <textarea name="deskripsi_usaha" id="deskripsi_usaha" rows="3"
                        placeholder="Ceritakan singkat tentang usaha Anda..."
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all resize-none">{{ old('deskripsi_usaha', $profile->deskripsi_usaha) }}</textarea>
                </div>
            </div>
        </div>

        {{-- ── Media Sosial ──────────────────────────────────────────── --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <h2 class="text-base font-black text-slate-900 mb-5 pb-3 border-b border-pink-100">
                <i class="fa-solid fa-share-nodes text-pink-500 mr-2"></i>Media Sosial Aktif <span class="text-slate-400 font-semibold text-sm">(Opsional)</span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">
                        <i class="fa-brands fa-instagram text-pink-500 mr-1"></i>Instagram
                    </label>
                    <input type="text" name="medsos_instagram" value="{{ old('medsos_instagram', $profile->medsos_instagram) }}"
                        placeholder="@namaakun"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">
                        <i class="fa-brands fa-tiktok text-slate-700 mr-1"></i>TikTok
                    </label>
                    <input type="text" name="medsos_tiktok" value="{{ old('medsos_tiktok', $profile->medsos_tiktok) }}"
                        placeholder="@namaakun"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">
                        <i class="fa-brands fa-facebook text-blue-600 mr-1"></i>Facebook
                    </label>
                    <input type="text" name="medsos_facebook" value="{{ old('medsos_facebook', $profile->medsos_facebook) }}"
                        placeholder="Nama halaman FB"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-200 focus:border-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-100 font-semibold text-slate-800 text-sm transition-all">
                </div>
            </div>
        </div>

        {{-- ── Dokumen Identitas ─────────────────────────────────────── --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <h2 class="text-base font-black text-slate-900 mb-2 pb-3 border-b border-pink-100">
                <i class="fa-solid fa-id-card text-pink-500 mr-2"></i>Dokumen Identitas
                <span class="text-slate-400 font-semibold text-sm">(Opsional - untuk verifikasi)</span>
            </h2>
            <p class="text-xs font-semibold text-slate-400 mb-5">Upload foto KTP/SIM sebagai verifikasi identitas pemilik usaha. Format: JPG, PNG, maks 2MB.</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                {{-- KTP --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-wide">Foto KTP</label>
                    @if($profile->foto_ktp)
                        <div class="mb-3 relative">
                            <img src="{{ asset('storage/' . $profile->foto_ktp) }}" alt="KTP" class="w-full h-32 object-cover rounded-2xl border-2 border-emerald-300">
                            <span class="absolute top-2 right-2 px-2 py-1 bg-emerald-500 text-white text-xs font-black rounded-lg">
                                <i class="fa-solid fa-check"></i> Sudah diupload
                            </span>
                        </div>
                        <p class="text-xs font-bold text-slate-400 mb-2">Upload ulang untuk mengganti:</p>
                    @endif
                    <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-pink-300 rounded-2xl cursor-pointer hover:bg-pink-50 transition-colors group">
                        <div class="text-center">
                            <i class="fa-solid fa-cloud-arrow-up text-pink-400 text-2xl mb-1 group-hover:text-pink-500 transition-colors"></i>
                            <p class="text-xs font-black text-slate-600 group-hover:text-pink-600">Pilih foto KTP</p>
                            <p class="text-xs text-slate-400 font-semibold">JPG, PNG – maks 2MB</p>
                        </div>
                        <input type="file" name="foto_ktp" id="foto_ktp" accept="image/*" class="hidden">
                    </label>
                    <p class="text-xs text-slate-400 font-semibold mt-1.5" id="ktp-filename"></p>
                    @error('foto_ktp')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- SIM --}}
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-wide">Foto SIM (Opsional)</label>
                    @if($profile->foto_sim)
                        <div class="mb-3 relative">
                            <img src="{{ asset('storage/' . $profile->foto_sim) }}" alt="SIM" class="w-full h-32 object-cover rounded-2xl border-2 border-emerald-300">
                            <span class="absolute top-2 right-2 px-2 py-1 bg-emerald-500 text-white text-xs font-black rounded-lg">
                                <i class="fa-solid fa-check"></i> Sudah diupload
                            </span>
                        </div>
                        <p class="text-xs font-bold text-slate-400 mb-2">Upload ulang untuk mengganti:</p>
                    @endif
                    <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-pink-300 rounded-2xl cursor-pointer hover:bg-pink-50 transition-colors group">
                        <div class="text-center">
                            <i class="fa-solid fa-cloud-arrow-up text-pink-400 text-2xl mb-1 group-hover:text-pink-500 transition-colors"></i>
                            <p class="text-xs font-black text-slate-600 group-hover:text-pink-600">Pilih foto SIM</p>
                            <p class="text-xs text-slate-400 font-semibold">JPG, PNG – maks 2MB</p>
                        </div>
                        <input type="file" name="foto_sim" id="foto_sim" accept="image/*" class="hidden">
                    </label>
                    <p class="text-xs text-slate-400 font-semibold mt-1.5" id="sim-filename"></p>
                    @error('foto_sim')<p class="text-rose-600 text-xs font-bold mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex gap-3">
            <button type="submit" id="btn-save-profile" class="flex-1 py-4 bg-gradient-to-r from-pink-500 to-rose-500 text-white font-black rounded-2xl hover:from-pink-600 hover:to-rose-600 shadow-lg shadow-pink-500/30 transition-all transform hover:-translate-y-0.5 text-sm">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Profil Usaha
            </button>
            <a href="{{ route('business.dashboard') }}" class="px-6 py-4 bg-slate-100 text-slate-700 font-black rounded-2xl hover:bg-slate-200 transition-all text-sm flex items-center">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    // Preview nama file yang dipilih
    document.getElementById('foto_ktp').addEventListener('change', function() {
        const name = this.files[0]?.name ?? '';
        document.getElementById('ktp-filename').textContent = name ? '📎 ' + name : '';
    });
    document.getElementById('foto_sim').addEventListener('change', function() {
        const name = this.files[0]?.name ?? '';
        document.getElementById('sim-filename').textContent = name ? '📎 ' + name : '';
    });
</script>
@endsection
