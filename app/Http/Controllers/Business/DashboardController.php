<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $profile = $user->businessProfile;

        $lokers = $user->jobListings()
            ->with('category')
            ->latest()
            ->get();

        $stats = [
            'total'     => $lokers->count(),
            'aktif'     => $lokers->where('status', 'aktif')->count(),
            'pending'   => $lokers->where('status', 'pending')->count(),
            'ditolak'   => $lokers->where('status', 'ditolak')->count(),
            'kadaluarsa' => $lokers->where('status', 'kadaluarsa')->count(),
            'premium'   => $lokers->where('is_premium', true)->count(),
        ];

        return view('business.dashboard', compact('user', 'profile', 'lokers', 'stats'));
    }
}
