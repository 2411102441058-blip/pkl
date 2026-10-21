<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\BusinessProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user    = auth()->user();
        $profile = $user->businessProfile ?? new BusinessProfile();

        return view('business.profile', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_pemilik'    => 'required|string|max:255',
            'nama_usaha'      => 'required|string|max:255',
            'no_hp'           => 'required|string|max:20',
            'alamat_usaha'    => 'nullable|string|max:500',
            'kategori_usaha'  => 'nullable|string|max:100',
            'deskripsi_usaha' => 'nullable|string|max:1000',
            'medsos_instagram' => 'nullable|string|max:100',
            'medsos_tiktok'   => 'nullable|string|max:100',
            'medsos_facebook' => 'nullable|string|max:100',
            'website'         => 'nullable|url|max:255',
            'foto_ktp'        => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto_sim'        => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'nama_pemilik.required' => 'Nama pemilik wajib diisi.',
            'nama_usaha.required'   => 'Nama usaha wajib diisi.',
            'no_hp.required'        => 'Nomor HP wajib diisi.',
            'foto_ktp.image'        => 'File KTP harus berupa gambar.',
            'foto_ktp.max'          => 'Ukuran file KTP maksimal 2MB.',
            'foto_sim.image'        => 'File SIM harus berupa gambar.',
            'foto_sim.max'          => 'Ukuran file SIM maksimal 2MB.',
            'website.url'           => 'Format URL website tidak valid.',
        ]);

        $user = auth()->user();
        $data = $request->only([
            'nama_pemilik', 'nama_usaha', 'no_hp', 'alamat_usaha',
            'kategori_usaha', 'deskripsi_usaha', 'medsos_instagram',
            'medsos_tiktok', 'medsos_facebook', 'website',
        ]);

        // Upload foto KTP
        if ($request->hasFile('foto_ktp')) {
            // Hapus file lama
            if ($user->businessProfile?->foto_ktp) {
                Storage::disk('public')->delete($user->businessProfile->foto_ktp);
            }
            $data['foto_ktp'] = $request->file('foto_ktp')->store('dokumen/ktp', 'public');
        }

        // Upload foto SIM
        if ($request->hasFile('foto_sim')) {
            if ($user->businessProfile?->foto_sim) {
                Storage::disk('public')->delete($user->businessProfile->foto_sim);
            }
            $data['foto_sim'] = $request->file('foto_sim')->store('dokumen/sim', 'public');
        }

        // Cek apakah profil sudah lengkap (minimal field wajib)
        $data['profil_lengkap'] = !empty($data['nama_pemilik'])
            && !empty($data['nama_usaha'])
            && !empty($data['no_hp']);

        $user->businessProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect()->route('business.dashboard')
            ->with('success', 'Profil usaha berhasil disimpan!');
    }
}
