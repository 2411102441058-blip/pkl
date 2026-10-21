<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;

class JobDetailController extends Controller
{
    /**
     * Menampilkan Halaman Detail Loker (FASE 3)
     */
    public function show($slug)
    {
        $job = JobListing::with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment jumlah kali dilihat (Analytics)
        $job->increment('views_count');

        // Rekomendasi Loker Serupa
        $relatedJobs = JobListing::aktif()
            ->where('id', '!=', $job->id)
            ->where('category_id', $job->category_id)
            ->limit(4)
            ->get();

        return view('jobs.show', compact('job', 'relatedJobs'));
    }
}
