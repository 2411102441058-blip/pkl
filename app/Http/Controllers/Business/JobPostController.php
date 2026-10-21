<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobPostController extends Controller
{
    public function create()
    {
        $user       = auth()->user();
        $profile    = $user->businessProfile;
        $categories = Category::orderBy('nama')->get();

        return view('business.post-job', compact('user', 'profile', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'posisi'         => 'required|string|max:255',
            'deskripsi'      => 'required|string|min:30',
            'syarat'         => 'nullable|string',
            'lokasi'         => 'required|string|max:255',
            'tipe_pekerjaan' => 'required|in:Full Time,Part Time,Freelance,Magang',
            'gaji'           => 'nullable|string|max:100',
            'is_premium'     => 'nullable|boolean',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'posisi.required'      => 'Posisi wajib diisi.',
            'deskripsi.required'   => 'Deskripsi pekerjaan wajib diisi.',
            'deskripsi.min'        => 'Deskripsi minimal 30 karakter.',
            'lokasi.required'      => 'Lokasi wajib diisi.',
            'tipe_pekerjaan.required' => 'Tipe pekerjaan wajib dipilih.',
            'bukti_pembayaran.image' => 'Bukti pembayaran harus berupa gambar.',
            'bukti_pembayaran.max'   => 'Ukuran maksimal foto bukti adalah 2MB.',
        ]);

        $user    = auth()->user();
        $profile = $user->businessProfile;

        if (!$profile || !$profile->profil_lengkap) {
            return redirect()->route('business.profile.edit')
                ->with('error', 'Harap lengkapi profil usaha Anda terlebih dahulu sebelum posting loker.');
        }

        $posisi = $request->posisi;
        $slug   = Str::slug($profile->nama_usaha . '-' . $posisi . '-' . uniqid());

        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('pembayaran', 'public');
        }

        JobListing::create([
            'user_id'          => $user->id,
            'category_id'      => $request->category_id,
            'nama_usaha'       => $profile->nama_usaha,
            'posisi'           => $posisi,
            'slug'             => $slug,
            'deskripsi'        => $request->deskripsi,
            'syarat'           => $request->syarat,
            'lokasi'           => $request->lokasi,
            'tipe_pekerjaan'   => $request->tipe_pekerjaan,
            'gaji'             => $request->gaji,
            'nomor_wa'         => $profile->no_hp,
            'status'           => 'pending',
            'is_premium'       => $request->boolean('is_premium'),
            'bukti_pembayaran' => $buktiPath,
        ]);

        return redirect()->route('business.dashboard')
            ->with('success', "Loker '{$posisi}' berhasil dikirim dan menunggu persetujuan admin.");
    }

    public function destroy(JobListing $job)
    {
        // Pastikan hanya pemilik yang bisa hapus
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }

        // Hanya izinkan hapus jika pending atau ditolak
        if (!in_array($job->status, ['pending', 'ditolak'])) {
            return back()->with('error', 'Loker yang aktif atau kadaluarsa tidak dapat dihapus. Hubungi admin.');
        }

        $job->delete();
        return back()->with('success', 'Loker berhasil dihapus.');
    }

    public function renew(JobListing $job)
    {
        if ($job->user_id !== auth()->id()) abort(403);

        $job->update([
            'status' => 'pending',
            'approved_at' => null,
            'expires_at' => null
        ]);

        return back()->with('success', 'Permintaan perpanjangan loker berhasil dikirim ke Admin.');
    }

    public function close(JobListing $job)
    {
        if ($job->user_id !== auth()->id()) abort(403);

        $job->update([
            'status' => 'kadaluarsa',
        ]);

        return back()->with('success', 'Loker berhasil ditandai sebagai sudah terisi / ditutup.');
    }
}
