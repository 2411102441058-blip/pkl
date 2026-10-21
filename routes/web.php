<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Business\DashboardController as BusinessDashboard;
use App\Http\Controllers\Business\ProfileController as BusinessProfile;
use App\Http\Controllers\Business\JobPostController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobDetailController;
use App\Http\Controllers\JobTrackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Portal Lowongan Kerja UMKM
|--------------------------------------------------------------------------
*/

// ─── PUBLIC: Pelamar / Pengunjung Biasa (tidak perlu login) ────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/loker/{slug}', [JobDetailController::class, 'show'])->name('jobs.show');
Route::post('/loker/{job}/track-click', [JobTrackController::class, 'trackClick'])->name('jobs.track-click');

// ─── AUTH: Login & Register ────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/daftar', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── BUSINESS OWNER: Pemilik Usaha (harus login + role pemilik_usaha) ──
Route::middleware(['auth', 'role:pemilik_usaha'])->prefix('usaha')->name('business.')->group(function () {
    Route::get('/dashboard', [BusinessDashboard::class, 'index'])->name('dashboard');

    // Profil Usaha
    Route::get('/profil', [BusinessProfile::class, 'edit'])->name('profile.edit');
    Route::post('/profil', [BusinessProfile::class, 'update'])->name('profile.update');

    // Posting Loker
    Route::get('/pasang-loker', [JobPostController::class, 'create'])->name('jobs.create');
    Route::post('/pasang-loker', [JobPostController::class, 'store'])->name('jobs.store');
    Route::delete('/loker/{job}', [JobPostController::class, 'destroy'])->name('jobs.destroy');
    Route::post('/loker/{job}/renew', [JobPostController::class, 'renew'])->name('jobs.renew');
    Route::post('/loker/{job}/close', [JobPostController::class, 'close'])->name('jobs.close');
});

// ─── ADMIN: Super Admin (harus login + role super_admin) ───────────────
Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/loker/{job}/approve', [AdminDashboardController::class, 'approve'])->name('jobs.approve');
    Route::post('/loker/{job}/reject', [AdminDashboardController::class, 'reject'])->name('jobs.reject');
    Route::post('/loker/{job}/toggle-premium', [AdminDashboardController::class, 'togglePremium'])->name('jobs.toggle-premium');
    Route::delete('/loker/{job}', [AdminDashboardController::class, 'destroy'])->name('jobs.destroy');
});

// ─── ADMIN LOGIN: Halaman login khusus admin ───────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminDashboardController::class, 'loginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminDashboardController::class, 'login'])->name('admin.login.post');
});
Route::post('/admin/logout', [AdminDashboardController::class, 'logout'])->name('admin.logout');

// ─── TEMPORARY: Reset password admin (hapus setelah digunakan) ─────────
if (app()->environment('local')) {
    Route::get('/reset-admin-password', function () {
        $newPassword = 'admin123';

        // Hapus user admin lama lalu buat ulang dari nol
        \Illuminate\Support\Facades\DB::table('users')
            ->where('email', 'admin@loker.com')
            ->delete();

        $id = \Illuminate\Support\Facades\DB::table('users')->insertGetId([
            'name'       => 'Admin Utama',
            'email'      => 'admin@loker.com',
            'password'   => \Illuminate\Support\Facades\Hash::make($newPassword),
            'role'       => 'super_admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ok = $id > 0;

        return '<!DOCTYPE html><html><body style="font-family:sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;background:#f0fdf4;margin:0">
        <div style="background:white;border:2px solid #22c55e;border-radius:16px;padding:2.5rem;max-width:420px;width:90%;box-shadow:0 10px 40px rgba(0,0,0,.1)">
            <div style="font-size:3rem;text-align:center">✅</div>
            <h2 style="color:#16a34a;text-align:center;margin:.5rem 0 1.5rem">Akun Admin Berhasil Dibuat Ulang!</h2>
            <table style="width:100%;border-collapse:collapse">
                <tr><td style="padding:.5rem;font-weight:bold;color:#374151">Email</td><td style="padding:.5rem;font-family:monospace;background:#f3f4f6;border-radius:6px">admin@loker.com</td></tr>
                <tr><td style="padding:.5rem;font-weight:bold;color:#374151">Password</td><td style="padding:.5rem;font-family:monospace;background:#f3f4f6;border-radius:6px">' . $newPassword . '</td></tr>
                <tr><td style="padding:.5rem;font-weight:bold;color:#374151">Status</td><td style="padding:.5rem;color:#16a34a;font-weight:bold">' . ($ok ? 'BERHASIL ✓' : 'GAGAL ✗') . '</td></tr>
            </table>
            <a href="/admin/login" style="display:block;margin-top:1.5rem;padding:.8rem;background:#ec4899;color:white;border-radius:10px;text-decoration:none;text-align:center;font-weight:bold;font-size:1rem">→ Login Admin Sekarang</a>
        </div></body></html>';
    });
}
