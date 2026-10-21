<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Mail\JobStatusMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan form login Admin
     */
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    /**
     * Proses Login Admin
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        try {
            $loggedIn = Auth::attempt($credentials, $request->boolean('remember'));
        } catch (\RuntimeException $e) {
            // Password di DB bukan format bcrypt — auto-fix dan coba lagi
            \Illuminate\Support\Facades\DB::table('users')
                ->where('email', $credentials['email'])
                ->update(['password' => \Illuminate\Support\Facades\Hash::make($credentials['password'])]);

            $loggedIn = Auth::attempt($credentials, $request->boolean('remember'));
        }

        if ($loggedIn) {
            // Pastikan user yang login adalah super_admin
            if (Auth::user()->role !== 'super_admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akses ditolak. Halaman ini khusus Admin.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang dimasukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout Admin
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'Berhasil keluar dari sesi Admin.');
    }

    /**
     * Dashboard Utama Moderasi Admin (FASE 2)
     */
    public function dashboard(Request $request)
    {
        $statusFilter = $request->input('status', 'pending');

        $stats = [
            'total' => JobListing::count(),
            'pending' => JobListing::where('status', 'pending')->count(),
            'aktif' => JobListing::where('status', 'aktif')->count(),
            'ditolak' => JobListing::where('status', 'ditolak')->count(),
            'kadaluarsa' => JobListing::where('status', 'kadaluarsa')->count(),
            'premium' => JobListing::where('is_premium', true)->count(),
        ];

        $query = JobListing::with(['category', 'user.businessProfile'])->latest();

        if (in_array($statusFilter, ['pending', 'aktif', 'ditolak', 'kadaluarsa'])) {
            $query->where('status', $statusFilter);
        }

        $jobs = $query->paginate(15)->withQueryString();

        return view('admin.dashboard', compact('jobs', 'stats', 'statusFilter'));
    }

    /**
     * FASE 2: Jalur YA - Admin menyetujui loker (Gratis / Premium)
     */
    public function approve(Request $request, JobListing $job)
    {
        $isPremium = $request->boolean('is_premium', false);

        $job->update([
            'status' => 'aktif',
            'is_premium' => $isPremium,
            'approved_at' => now(),
            'expires_at' => now()->addDays(30),
        ]);

        if ($job->user && $job->user->email) {
            $mailStatus = $isPremium ? 'approved_premium' : 'approved_gratis';
            Mail::to($job->user->email)->send(new JobStatusMail($job, $mailStatus));
        }

        $statusText = $isPremium ? 'Aktif (PREMIUM ⭐)' : 'Aktif (Gratis)';

        return redirect()->back()->with('success', "Lowongan '{$job->posisi}' di '{$job->nama_usaha}' berhasil disetujui dengan status: {$statusText}.");
    }

    /**
     * FASE 2: Jalur TIDAK - Admin menolak loker
     */
    public function reject(JobListing $job)
    {
        $job->update([
            'status' => 'ditolak',
        ]);

        if ($job->user && $job->user->email) {
            Mail::to($job->user->email)->send(new JobStatusMail($job, 'rejected'));
        }

        return redirect()->back()->with('success', "Lowongan '{$job->posisi}' di '{$job->nama_usaha}' telah DITOLAK.");
    }

    /**
     * Toggle Fitur Premium pada loker yang sudah aktif
     */
    public function togglePremium(JobListing $job)
    {
        $job->update([
            'is_premium' => !$job->is_premium,
        ]);

        $statusStr = $job->is_premium ? 'diaktifkan sebagai Premium ⭐' : 'diubah menjadi Gratis';

        return redirect()->back()->with('success', "Status Premium loker '{$job->posisi}' berhasil {$statusStr}.");
    }

    /**
     * Hapus Loker dari Database
     */
    public function destroy(JobListing $job)
    {
        $job->delete();

        return redirect()->back()->with('success', 'Data lowongan kerja berhasil dihapus.');
    }
}
