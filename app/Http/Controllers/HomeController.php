<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JobListing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = JobListing::aktif()->with('category');

        // Search Filter (Posisi / Nama Usaha / Deskripsi)
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('posisi', 'like', "%{$search}%")
                  ->orWhere('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Category Filter
        if ($request->filled('kategori')) {
            $categorySlug = $request->input('kategori');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Location Filter
        if ($request->filled('lokasi')) {
            $lokasi = $request->input('lokasi');
            $query->where('lokasi', 'like', "%{$lokasi}%");
        }

        $jobs = $query->paginate(12)->withQueryString();
        $categories = Category::withCount(['jobListings' => function ($q) {
            $q->where('status', 'aktif');
        }])->get();

        return view('home', compact('jobs', 'categories'));
    }
}
