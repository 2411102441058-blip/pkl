<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;

class JobTrackController extends Controller
{
    /**
     * Increment the WhatsApp click count for a job listing via AJAX.
     */
    public function trackClick(Request $request, JobListing $job)
    {
        $job->increment('clicks_count');

        return response()->json([
            'success' => true,
            'clicks_count' => $job->clicks_count
        ]);
    }
}
